The main aim for Perssonal (or peRRSonal) is to ease the creation of on-the-fly RSS feeds. Creating a single RSS feed is nothing special, but when you have multiple, you need something more flexible. Perssonal tries to fill this need.

Perssonal basically has two parts, the link to a feed and the feed itself.


## Creating the link

It's pretty simple actually... just use the `{exp:perssonal:link}` tag and assign whatever parameters you need to it.

    <a href="{exp:perssonal:link channel='blog'}">Blog RSS</a>

This example doesn't do it justice, so here are a few that show off it's true potential:

    // Serve up a separate feed for every category
    <ul>
      {exp:channel:categories style='linear' channel='blog'}
        <li><a href="{exp:perssonal:link channel='blog' category='{category_id}'}">{category_name} feed</a></li>
      {/exp:channel:categories}
    </ul>

    // A feed showing only entries from a particular user
    {exp:user:users group_id='9'}
      <a href="{exp:perssonal:link channel='articles' author_id='{member_id}'}">User feed</a>
    {/exp:user:users}

As you can see it supports a few tag parameters, but here's the full list of supported parameters:

author_id
category
category_group
channel
group_id
limit
status
uncategorized_entries
username
search:field_name

All of these parameters behave in exactly the same fashion as the channel:entries equivalent. In addition to these parameters that effect which entries are shown, the following parameters are used to add feed specific information:

feed_name
feed_url
feed_description

## Creating the feed

A link to a page is fun, but without something actually serving up the feed it's not of much use, is it?

Create template
Add code
{feed_parameters}