package processing.app;

import java.io.*;
import java.util.Enumeration;
import java.util.zip.*;

public class Obfuscator implements MessageConsumer {
  
  public Obfuscator() {    
  }
  
  public boolean obfuscate(File source, File output) {
    String wtkPath = Preferences.get("wtk.path");
    String wtkBinPath = wtkPath + File.separator + "bin" + File.separator;
    String wtkLibPath = wtkPath + File.separator + "lib" + File.separator;
    
    //// cldc version
    String cldc = Preferences.get("wtk.cldc");
    if (cldc == null) {
        //// default 1.0
        cldc = "10";
    }
    String midp = Preferences.get("wtk.midp");
    if (midp == null) { 
        //// default 1.0
        midp = "10";
    }
    
    boolean isWindows = Base.isWindows();
    //// process library path to only include jar files
    StringBuffer libraries = new StringBuffer();
    String[] tokens = Base.librariesClassPath.split(File.pathSeparator);
    for (int i = 0, length = tokens.length; i < length; i++) {
        if (tokens[i].toLowerCase().endsWith(".jar")) {
            libraries.append(File.pathSeparator);
            libraries.append("'");
            if (isWindows) {
                libraries.append("\"");
            }
            libraries.append(tokens[i]);
            if (isWindows) {
                libraries.append("\"");
            }
            libraries.append("'");
        }
    }
    
    StringBuffer command = new StringBuffer();
    command.append("java -jar lib");
    command.append(File.separator);
    command.append("proguard.jar -libraryjars ");
    if (Base.isMacOS()) {
        command.append("'lib");
        command.append(File.separator);
        command.append("cldcapi");
        command.append(cldc);
        command.append(".jar'");
        command.append(File.pathSeparator);
        command.append("'lib");
        command.append(File.separator);
        command.append("midpapi");
        command.append(midp);
        command.append(".jar'");      
        command.append(libraries.toString());
        command.append(" -injars '");
        command.append(source.getPath());
        command.append("' -outjar '");
        command.append(output.getPath());
        command.append("' ");
    } else {
        command.append("'");
        if (isWindows) {
            command.append("\"");
        }
        command.append(wtkLibPath);
        command.append("cldcapi");
        command.append(cldc);
        command.append(".jar");
        if (isWindows) {
            command.append("\"");
        }
        command.append("'");
        command.append(File.pathSeparator);
        command.append("'");
        if (isWindows) {
            command.append("\"");
        }
        command.append(wtkLibPath);
        command.append("midpapi");
        command.append(midp);
        command.append(".jar");      
        if (isWindows) {
            command.append("\"");
        }
        command.append("'");
        command.append(libraries.toString());
        command.append(" -injars '");
        if (isWindows) {
            command.append("\"");
        }
        command.append(source.getPath());
        if (isWindows) {
            command.append("\"");
        }
        command.append("' -outjar '");
        if (isWindows) {
            command.append("\"");
        }
        command.append(output.getPath());
        if (isWindows) {
            command.append("\"");
        }
        command.append("' ");
    }
    command.append("@lib");
    command.append(File.separator);
    command.append("proguard.pro");
    //System.out.println(command.toString());
    try {
      Process p = Runtime.getRuntime().exec(command.toString());
      new MessageSiphon(p.getInputStream(), this);
      new MessageSiphon(p.getErrorStream(), this);
      
      boolean running = true;
      int result = -1;
      while (running) {
        try {
          result = p.waitFor();
          
          running = false;
        } catch (InterruptedException ie) {
          ie.printStackTrace ();
        }
      }
      if (result != 0) {
          return false;
      }
      //// extract
      extract(output);
      //// delete jar
      output.delete();
    } catch (Exception e) {
      e.printStackTrace ();
    }
    
    return false;
  }
  
  public void message(String s) {
    System.err.println(s);
  }  
  
  public static void extract(File zipfile) throws Exception {
      File dir = zipfile.getParentFile();
      ZipFile zip = new ZipFile(zipfile);
      Enumeration e = zip.entries();
      while (e.hasMoreElements()) {
          ZipEntry ze = (ZipEntry) e.nextElement();
          InputStream is = zip.getInputStream(ze);
          File outfile = new File(dir, ze.getName());
          File parent = outfile.getParentFile();
          if (!parent.exists()) {
              parent.mkdirs();
          }
          OutputStream os = new FileOutputStream(outfile);
          byte[] buffer = new byte[4096];
          int bytesRead = is.read(buffer);
          while (bytesRead >= 0) {
              os.write(buffer, 0, bytesRead);
              bytesRead = is.read(buffer);
          }
          os.close();
          is.close();
      }
      zip.close();
  }
  
  public static void compress(File source, File output) throws Exception {
      ZipOutputStream os = new ZipOutputStream(new FileOutputStream(output));
      compress(source, "", os);
      os.finish();
      os.close();
  }
  
  private static void compress(File source, String prefix, ZipOutputStream os) throws Exception {
      File[] files = source.listFiles();
      for (int i = 0, length = files.length; i < length; i++) {
          if (!files[i].getName().startsWith(".")) {
              if (files[i].isDirectory()) {
                  ZipEntry ze = new ZipEntry(prefix + files[i].getName() + "/");
                  os.putNextEntry(ze);
                  os.closeEntry();
                  compress(files[i], prefix + files[i].getName() + "/", os);
              } else {
                  ZipEntry ze = new ZipEntry(prefix + files[i].getName());
                  os.putNextEntry(ze);
                  byte[] buffer = new byte[4096];
                  FileInputStream is = new FileInputStream(files[i]);
                  int bytesRead = is.read(buffer);
                  while (bytesRead >= 0) {
                      os.write(buffer, 0, bytesRead);
                      bytesRead = is.read(buffer);
                  }
                  os.closeEntry();
                  is.close();
              }
          }
      }
  }
}
