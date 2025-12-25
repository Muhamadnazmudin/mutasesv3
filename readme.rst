###################
What is Mutases
###################

**Mutases** is a **CodeIgniter 3–based application** designed to manage student transfer (mutation) data and school administrative processes.  
This project represents the **development version (v2)**, focusing on improved PHP compatibility, better application stability, and cleaner code structure.

---

Release Information

---

This repository contains the source code for **Mutases v2**, which has been adjusted and tested using the latest stable PHP version recommended for CodeIgniter 3.

---

Changelog & New Features

---

- Upgraded PHP compatibility from **PHP 5.6** to **PHP 7.4**
- Improved and refactored code structure for better stability and maintainability
- Updated and adjusted libraries to ensure safe and optimal execution on PHP 7.4

---

Server Requirements

---

**PHP 7.4 (Recommended & Used)**

- PHP >= 7.4
- CodeIgniter 3
- MySQL / MariaDB
- Apache / Nginx
- Composer

> **Note:**  
> CodeIgniter 3 officially supports PHP 5.6 as the **minimum requirement**.  
> However, **Mutases v2** is **optimized and actively run on PHP 7.4**  
> to provide better security, performance, and overall compatibility.
>
> Starting from this version, **Mutases v2** has been renamed to  
> **SimsGTK (Student and Teacher Information System)**.

---

Installation

---

1. Clone this repository into your web server directory
2. Before running Composer, make sure your `composer.json` file is configured as follows:

```json
{
	"description": "The CodeIgniter framework",
	"name": "codeigniter/framework",
	"type": "project",
	"homepage": "https://codeigniter.com",
	"license": "MIT",
	"require": {
		"php": ">=5.3.7",
		"phpoffice/phpspreadsheet": "1.23.*",
		"psr/simple-cache": "^1.0",
		"smalot/pdfparser": "^2.12"
	},
	"config": {
		"platform-check": false,
		"audit": {
			"block-insecure": false
		}
	}
}
composer install --no-scripts