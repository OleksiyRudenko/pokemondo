http://codepen.io/justincron/pen/imELF

Share button bootstrap


https://www.facebook.com/help/community/question/?id=10200814000150949

Here's how this works all:

1. You need the ability to access the HTML on the particular 
webpage you are sharing. It'll probably work site wide too 
if you use a common header file. I have not tried this, 
but it should work. You'll just get the same image for 
all pages if you do this though.

2. You need to add these HTML meta tags into page in the 
`<head></head>`. It will not work if you put it in the 
`<body></body>`. Make sure to customize per your
    - image, 
    - description, 
    - URL, and 
    - title.

A Real Example.

`<meta property="og:image" content="http://www.coachesneedsocial.com/wp-content/uploads/2014/12/BannerWCircleImages-1.jpg" />`

`<meta property="og:description" content="Coaches share their secrets to success so you can rock 2015. Join us for this inspiring, rejuvenating, motivating look at what secret sauce these coaches use to succeed in their business. This is for coaches of any level that are committed to changing the world. You will be elevated both in your life and your coaching business. Check out the topics below, there is something for everyone." />`

`<meta property="og:url"content="http://www.coachesneedsocial.com/coacheswisdomtelesummit/" />`

`<meta property="og:title" content="Coaches Wisdom Telesummit" />`

3. Save
4. Open a fresh Facebook post, and retry the page 
you wanted to share.
5. If you are having trouble, you can debug it with 
this Facebook tool. It looks more geeky than it is. 
It tells you what Facebook is seeing when you post 
in the URL to share.

https://developers.facebook.com/tools/debug/og/object/

Big Tip.. make sure the "quote marks" are the same in 
your HTML (they should look like 2 straight marks and 
no curves; sometimes programs change these to different 
fonts and it goofs up the code.