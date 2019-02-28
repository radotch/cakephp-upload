# Upload plugin for CakePHP

## Note

Hi, there

I am developed this plugin for my own needs. The main task is to move uploaded file
on the local file system.

If that covers your needs, use the plugin for free.

## Description

The plugin automate process of upload files and is easy to use with short configuration.


## Requirements

 - CakePHP >= 3.7
 - PHP >= 7.0 / recommended 7.2 

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```
composer require radotch/cakephp-upload
```

## Usage

### Behavior

To automate the process of upload files on the server, add Uploadable Behavior
in the Model initialize() hook:

```
public function initialize($config = [])
{
    // Other code
    $this->addBehavior('CakeUpload.Uploadable', []);
}
```

#### Behavior configuration

You have to configure all fields that contain uploaded file. No limit of their 
number but don't forget that have other outer restrictions from servers, forms, e.t.c.

```
public function initialize($config)
{
    // Other code
    $this->addBehavior('CakeUpload.Uploadable', [
        'field-1',
        'field-2',
        'field-3' => [
            'path' => 'path/to/move/uploaded/file'
        ],
        e.t.c.
    ]);
}
```

The settings of configured fields are:
 - **path** - relative to CakePHP webroot directory. If not set default path is used.

#### Behavior features

 - Check once again configured fields for errors before save.
 - If any error is found apply it to entity and stop upload and save process.
 - Move uploaded file in the local file system.
 - On edit if entity field is changed, remove old file or just replace if file names are equal.
 - When delete entity remove all attached files.

**Note:** Operates only with single uploaded file. Multiple is not supported.

#### Mixin methods

 - getPath(string $field, array $settings = [])  - get configured path or default
 - setPath(string $field, string $path)  - allow to set path (relative to webroot) on the fly.