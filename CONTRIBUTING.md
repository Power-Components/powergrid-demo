# PowerGrid Demo Contribution Guide

`💓` **Thank you for your interest in contributing to PowerGrid Demo.**

```plain
❗ This guide is a work in progress ❗
```

## Adding Examples

- Example Components in `app/Livewire`. **IMPORTANT**: Filenames must end with `Table.php`

- Each component description (about) will be automatically loaded from `resources/markdown/Components`. **IMPORTANT**: The filename must match its corresponding component (e.g, `app/Livewire/MyTable.php` → `resources/markdown/Components/MyTable.md`)

- The menu is built automatically based on files in `app/Livewire` and entries in `config/menu.php`.
