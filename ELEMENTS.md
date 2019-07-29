# Block Editor Compatibility

This section file describes you with the most important points to start developing sections for Smart Team Workflow .
Currently ,The Folowing Smart Team Workflow Modules are compatible and handled with Gutenberg Block Editor .

* Custom Status

### Setup

*Note:* This document assumes you have a working knowledge of modern JavaScript and its tooling, including: npm, Webpack, and, of course, React.

Prerequisites: `npm`, `yarn` (optionally).

From the plugin's folder run:

```
npm i
```

or

```
yarn
```

This should leave you with everything you need for development, including local copy of Webpack and webpack-cli.


## Anatomy of an Smart Team Workflow Section.

We have a two parts for Block Editor compatibility implementation for each element.

#### PHP

**TL;DR;** check out
[Custom Status element](elements/custom-status/custom-status.php) and its corresponding [Block Editor Compat](elements/custom-status/compat/block-editor.php) for the working example.

On the PHP side, in the module's folder create a `compat` sub-folder, and in it, create a file named `block-editor.php`.

That file has to contain the class ${EF_Module_Class_Name}_Block_Editor_Compat.
E.g., for the `Custom Status` element, which class name is `stworkflow_Custom_Status`, the compat class name has to be `stworkflow_Custom_Status_Block_Editor_Compat`.


Here's a  contrived example of a fictional module:

`elements/fictional-module/fictional-module.php`:

```php
<?php
class stworkflow_Fictional_Module {
  protected $compat_hooks = [
    'admin_enqueue_scripts' => 'element_admin_scripts'
  ];

  function element_admin_scripts() {
    // something-something, not compatible with Gutenberg
  }
}
```

`elements/fictional-element/compat/block-editor.php`:

```php
<?php
class stworkflow_Fictional_element_Block_Editor_Compat {
  // @see in "common/php/trait-block-editor-compatible.php
  use Block_Editor_Compatible;

  // Holds the reference to the module, so that we can use the module's logic.
  $ef_module;

  function element_admin_scripts() {
    $this->stworkflow_element->do_something_with_element();
  }
}
```

**Important**

To avoid  class inheritance complexities, Smart Team Workflow compat files use a trait [Block_Editor_Compatible](admin/php/trait-block-editor-compatible.php). Be sure to check it out before implementing compatibility for other elements.

##### How does it work?

Each Smart Team Workflow element follows the same pattern: attaching the necessary hooks for actions and filters on instantiation.

We have modified the loader logic in the main St_Workflow class to try to instantiate the Block_Editor_Compat for corresponding element.

This way the code for existing modules doesn't need to be modified, except adding the `protected $compat_hooks` property.

On the instantiation of the element's compatibility class, we'll iterate over `$compat_hooks` and remove the hooks registered by the element, and add ones defined in the compat class.

#### JavaScript

##### Development

To start the Webpack in watch mode:

```npm run dev```

##### Build for production

To generate optimized/minified production-ready files:

```npm run build```

##### File Structure

```
sections/
  # Source files:
  src/
    element-slug/
      block.js # Gutenberg Block code for the module
      editor.scss # Editor styles
      style.scss # Front-end styles
  # Build
  dist/
    element-slug.build.js # Built block js
    element-slug.editor.build.css # Built editor CSS
    element-slug.style.build.css # Built front-end CSS
```

The files from `dist/` should be enqueued in the compat class for the element.

See [Custom Statuses Compatibility Class](elements/custom-status/compat/block-editor.php) for implementation details. 

**Please note:** this is a Work-In-Progress, most likely there will be major changes in the near future. 