# Nova Resource Categoriser

This is a packages to make your side menu in Nova a bit nicer. This package works with the normal `$group` variable from Nova to group your resources. What this package does, is it collapses your groups to keep it nice and tidy. Also you are able to add an icon to your groups to make nagivating even more fun.

<img src="https://raw.githubusercontent.com/marshmallow-packages/categorise-resources/master/resources/images/screenshot.png">

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require marshmallow/categorise-resources
```

## Usage

In any / all of your resources add

```php
public static $group = "Your Category label";
```

## Icons
You can add svg icon from http://www.zondicons.com/icons.html. To use an icon, please follow the steps below.
 - [] Download zondicons and open `*.svg` icon in browser
 - [] `right click` in browser and choose inspect element
 - [] Copy the svg tag and place it in a `$group_icon` parameter on one of the resources in the group. We will use the first we find in the group.
 - [] Add the class `sidebar-icon` to the svg tag like so: `<svg class="sidebar-icon">`.
 - [] Add the fill attibute `var(--sidebar-icon)` to the path tag like so: `<path fill="var(--sidebar-icon)">`.

```php
class Customer extends Resource
{
    public static $group = 'Customers';

    public static $group_icon = '<svg class="sidebar-icon" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="icon-shape"><path fill="var(--sidebar-icon)" d="M12,16 L9,16 L11,11.5 L11,8.99791312 C11,7.89449617 11.8982606,7 12.9979131,7 L15.0020869,7 C16.1055038,7 17,7.89826062 17,8.99791312 L17,11.5 L19,16 L16,16 L16,20 L12,20 L12,16 Z M7,13 L9,13 L9,8.99791312 C9,7.89826062 8.10541955,7 7.00189865,7 L2.99810135,7 C1.88670635,7 1,7.89449617 1,8.99791312 L1,13 L3,13 L3,20 L7,20 L7,13 Z M5,6 C6.65685425,6 8,4.65685425 8,3 C8,1.34314575 6.65685425,0 5,0 C3.34314575,0 2,1.34314575 2,3 C2,4.65685425 3.34314575,6 5,6 Z M14,6 C15.6568542,6 17,4.65685425 17,3 C17,1.34314575 15.6568542,0 14,0 C12.3431458,0 11,1.34314575 11,3 C11,4.65685425 12.3431458,6 14,6 Z" id="Combined-Shape"></path>';

    // ...
}
```


### Security

If you discover any security related issues, please email stef@marshmallow.dev instead of using the issue tracker.

## Credits

- [Alex Bowers](https://github.com/alexbowers)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
