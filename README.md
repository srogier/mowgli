Mowgli
======

Mowgli allows you to easily create helpfull CLI application with PHP.

It uses several components of Symfony including Console


Create an application
-----------

{{{
mowgli generate:project foo
}}}

Add a command on a project
------------

{{{
mowgli generate:command bar
}}}

The new command will be launch with

bin/foo bar

Create a phar to distribute the application
------------

{{{
bin/foo compile
}}}


Install application
------------

{{{
bin/foo install
}}}



