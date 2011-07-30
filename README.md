The main aim for Perssonal (or peRRSonal) is to ease the creation of on-the-fly RSS feeds. Creating a single RSS feed is nothing special, but when you have multiple, you need something more flexible. Perssonal tries to fill this need.

Perssonal basically has two parts, the link to a feed and the feed itself.


## Creating the link

It's pretty simple actually... just use the `{exp:perssonal:link}` tag and assign whatever parameters you need to it.

    <a href="{exp:perssonal:link path='feeds' channel='blog'}">Blog RSS</a>

This example doesn't do it justice, so here are a few that show off it's true potential:

    // Serve up a separate feed for every category
    <ul>
      {exp:channel:categories style='linear' channel='blog'}
        <li><a href="{exp:perssonal:link path='feeds' channel='blog' category='{category_id}'}">{category_name} Feed</a></li>
      {/exp:channel:categories}
    </ul>

    // A feed showing only entries from a particular user
    {exp:user:users group_id='9'}
      <a href="{exp:perssonal:link path='feeds' channel='articles' author_id='{member_id}'}">User Article Feed</a>
    {/exp:user:users}

As you can see it supports a few tag parameters, but here's the full list of supported parameters:

* author_id
* category
* category_group
* channel
* group_id
* limit
* status
* uncategorized_entries
* username
* search:field_name

All of these parameters behave in exactly the same fashion as the `{exp:channel:entries}` equivalent. In addition to these parameters that effect which entries are shown, the following parameters are used to add feed specific information:

* path : Location of your RSS template ('/feeds')
* feed_name : The name of your feed ('Blog')
* feed_url : The URL to which page the feed is related to ('/blog/')
* feed_description : A short description of your feed ('Your daily updates about ExpressionEngine.')

And this how they are used:

    <a href="{exp:perssonal:link channel='news' feed_url='news' feed_name='News' feed_description='This is a test feed to see if Perssonal works.'}">Subscribe</a>

Showing up somewhere to find out nothing is there is no fun, so lets get on with creating the actual feed.

## Creating the feed

I've included a sample template with this add-on to start you off, but it is pretty simple.

    {exp:perssonal:feed hash='{segment_2}'}
    <?xml version="1.0" encoding="utf-8"?>
    <rss version="2.0"
        xmlns:dc="http://purl.org/dc/elements/1.1/"
        xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
        xmlns:admin="http://webns.net/mvcb/"
        xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
        xmlns:content="http://purl.org/rss/1.0/modules/content/">
        <channel>
        <title><![CDATA[{feed_name}]]></title>
        <link>{feed_url}</link>
        <description>{feed_description}</description>
        <dc:language>{feed_language}</dc:language>
        <dc:creator>{email}</dc:creator>
        <dc:rights>Copyright {gmt_date format="%Y"}</dc:rights>
        <dc:date>{gmt_date format="%Y-%m-%dT%H:%i:%s%Q"}</dc:date>
      {exp:channel:entries {perssonal:parameters}}
        <item>
          <title><![CDATA[{title}]]></title>
          <link>{title_permalink}</link>
          <guid>{title_permalink}#When:{gmt_entry_date format="%H:%i:%sZ"}</guid>
          <description><![CDATA[{summary}{body}]]></description>
          <dc:subject><![CDATA[{categories limit='1'}{category_name}{/categories}]]></dc:subject>
          <dc:date>{gmt_entry_date format="%Y-%m-%dT%H:%i:%s%Q"}</dc:date>
        </item>
      {/exp:channel:entries}
        </channel>
    </rss>    
    {/exp:perssonal:feed}
    
First create a template and set the template type to 'RSS Page'.

Start off with adding the `{exp:perssonal:feed hash='{segment_x}'}{/exp:perssonal:feed}` tags. The hash parameter is used to identify which feed to serve up. Make sure you fetch it from the right segment. If the URL used to access the feed looks like `/feeds/{hash}` you have to specify {segment_2} in the hash parameter.

After that, add the necessary tags for your RSS feed like shown in the sample template.

I've chosen to keep things simple and leverage the power of the channel:entries tag to display the entries. This way everything that is supported by the `{exp:channel:entries}` tag will also be supported by Perssonal. The only thing that is different is that you don't (have to) specify any parameters... By adding the `{perssonal:parameters}` tag to the `{exp:channel:entries}` tag Perssonal takes care of that for you.

After that it is as simple as adding whatever tags or custom fields to your template as you would do in a normal template.

I am by no means an expert on RSS, so if you can think of any improvements on my sample template or the code in general, drop me a line!


**Links**<br />
[Support](http://support.baseworks.nl/discussions/perssonal)<br />
[Twitter](http://twitter.com/AboutWout)<br />
[Developer](http://www.baseworks.nl/)<br />