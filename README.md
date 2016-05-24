mekit_nh_pathauto
=================

Drupal 7 module that fixes the following problems when nodehierarchy is in use in conjunction with pathauto:

    - when pathauto is using an url alias pattern which refers to node parent 
       such as: [node:nodehierarchy:parent:url:path]/[node:title]
       when editing a node, if the parent does not have an alias already generated, 
       the alias of the node will not be correct.
       
    - when removing and re-generating all content aliases, if the order of the generation
       does not follow the hierarchy of the nodes defined in nodehierarchy, 
       the aliases of child nodes will not be correct until their parents are without an alias
       
Usage:
------

Install, activate and use.

