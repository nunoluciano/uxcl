<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html"/>

<xsl:template match="rss/channel">
    <html>
    <head>
        <title><xsl:value-of select="title"/></title>
                
        <!--<link rel="alternate" type="application/rss+xml" title="RSS" href="rss.xml" />-->
        
        <style type="text/css">
        <![CDATA[
        
            /* 
            ** CSS stylesheet for RSS files
            */
            
            body {
                margin: 1em 1em 2em 1em;
                font-size: 100%;
                font-family: Tahoma, Arial, Verdana, Helvetica, Sans-serif;
                text-align: center;  
            }
            
            
            /* 
            ** channel styles: 
            */
            
            #page {
                font-size: 0.8em;
                margin: 0 auto;
                width: 60%;
                text-align: left;
            }

            #header h1 {
                font-family: Arial;
                font-size: 1.5em;
                margin-bottom: 0.4em;
            }
            
            #header p {
                font-size: 0.9em;
                margin-bottom: 2em;
                color: #737373;
            }
            

            #footer {
                text-align: center;
            }

           /* 
            ** item styles: 
            */
            
            .item {
                padding: 0.5em;
                margin-bottom: 1.4em;
                border: 1px solid #ccc;
                background-color: #eeeeee;
            }
            
            .item a {
                font-family: Arial, Verdana;
                font-size: 1.1em;
                font-weight: bold;
                margin-bottom: 0.5em;
                text-decoration: underline;
                color: #0000FF;
                cursor: pointer;
            }
            
            .item a:hover, .item a:active {
                color: #FF0000;
            }
            
            .item .description {
                margin: 0.3em 0em 0.3em 0em;
            }
            
            .item .pubDate {
                font-size: 0.9em;
                border-top: 1px solid #cccccc;
                margin-top: 1.2em;
                padding-top: 0.5em;
                color: #949494;
                padding-bottom: 0em;
                margin-bottom: 0em;
            }        

        ]]>
        </style>

    </head>
    
    <body>
    
        <div id="page">            
        
            <div id="header">
                <h1><a href="{link}"><xsl:value-of select="title"/></a></h1>
                <p><xsl:value-of select="description"/></p>
            </div>                

            <xsl:for-each select="item">
                <div class="item">                    
                    <a href="{link}"><xsl:value-of select="title"/></a>    
                    
                    <p class="description">
                        <xsl:value-of select="description" disable-output-escaping="yes" />
                    </p>
                    
                    <xsl:if test="pubDate">
                        <p class="pubDate">Date: <xsl:value-of select="pubDate"/></p>
                    </xsl:if>
                </div>                        
            </xsl:for-each>
        
            <div id="footer">
                Last update: <xsl:value-of select="lastBuildDate"/><br />               
                <xsl:if test="copyright"> - <xsl:value-of select="copyright"/><br /></xsl:if>
            </div>
        
        </div>
        
    </body>
    </html>
</xsl:template>
    
</xsl:stylesheet>