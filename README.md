# Documentation

## What's it about?

This project is a Content Management System for a blog.

## Functionality

- User authentication system
- CRUD functionality for Blog posts
- CRUD functionality for comments
- Dynamically edit the navbar in the admin dashboard (similar to the WordPress functionality)
  - create new links for the navbar
  - select which link are shown
  - change order of navbar link via drag & drop

## Tech Stack

- PHP
- JavaScript
- MySQL
- Bootstrap 4

## Quick Start

In <code>app/config/config.php</code>, replace the values of the constants with your own ones.</br>
Also in the <code>app/config/</code> directory, create a file named <code>secrets.php</code>.</br>
In <code>secrets.php</code>, define a constant like so:

<pre><code><?php define("TINYMCE_API_KEY", "your_tinyMCE_API_key");</code></pre> </br>

The name of the constant must be exactly the same. </br>
You can create your tinyMCE API key for free here: https://www.tiny.cloud/auth/signup/
