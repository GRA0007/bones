# Bones

Bones is a simple, flat-file CMS that uses modules and components to build a static website.

Pages are defined in YAML format, e.g.

```yaml
# Page: _home (default page)

meta:
    title: Sample Page
    description: This page is just a sample

content:
    header:
        image:
            src: image.png
            width: 200px
        title: Sample Page

    nav:
        links:
          - text: Home
            link: /

          - text: About
            link: /about/

    text:
        body: >
        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
            non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
```

Each page is made of modules, like `header`, `nav` and `text`. These are also defined in YAML, e.g.

```yaml
# Module: header

template: header.php

fields:
    image:
        type: component
        fields:
            src:
                type: image
            height:
                type: dimension
                default: initial
            width:
                type: dimension
                default: initial
    title:
        type: heading
```

The module's also each have a corresponding template file, which is used to display the content.
Finally, there are types. Each data type is also defined in it's own YAML file, e.g.

```yaml
# Type: image

primitive: file
preprocess: image_link
attributes: accept="image/*"
```

Most of the config for types is used to denote how the CMS displays the input field for a content editor.
The `preprocess` field can be set to a function that alters the value, like the above `image_link` function,
which could prepend the full path to the image folder before the image file name.

The CMS allows content editors to create pages from the modules available to them, as defined by a developer.
