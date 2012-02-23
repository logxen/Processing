package writers;

import java.io.IOException;
import java.util.HashMap;

import com.sun.javadoc.MethodDoc;

public class MethodWriter extends BaseWriter {
	public MethodWriter(){}
	
	/**
	 * 
	 * 
	 * @param vars the inherited vars from the method's ClassDoc
	 * @param doc the method doc
	 * @throws IOException
	 */
	public static void write( HashMap<String, String> vars, MethodDoc doc) throws IOException
	{
		String filename = getAnchor(doc);
		TemplateWriter templateWriter = new TemplateWriter();
		
		if(Shared.i().isRootLevel(doc.containingClass())){
			vars.put("classname", "");
		} else {
			vars.put("classanchor", getLocalAnchor(doc.containingClass()));
		}
		
		vars.put("examples", getExamples(doc));
		vars.put("description", getXMLDescription(doc));
		vars.put("name", getName(doc));
		String syntax = templateWriter.writeLoop("method.syntax.partial.html", getSyntax(doc, getInstanceName(doc)));
		vars.put("syntax", syntax);
		vars.put("returns", getReturnTypes(doc));
		
		vars.put("parameters", getParameters(doc));
		vars.put("usage", getUsage(doc));
		vars.put("related", getRelated(doc));
		
		templateWriter.write("generic.template.html", vars, filename);
	}
	
}
