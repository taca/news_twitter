# News Twitter

## What is it?

This is Contao's extension module News Twitter, sends a status update
to Twitter when you publish news item.

It was originaly written by Andreas Schempp (andreas.schempp)
http://www.iserv.ch/ and this is some tweaked code for recent Contao.

## What changed?

* Multi domain support; when using multidomain on Contao and enabling "Include
  news link", the link wasn't always generated correctly.

* Twitter's authenticated key and secrets are hold in each news archive
  instead of global setting.  So, each news archive use different Twitter
  account now.

* Log a message of successfully posted to Twitter.

## Caution

* This version depend on Contao 2.11 and later.
