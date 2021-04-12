# WordPress-Kanban

Kanban board app with Vue.js using WordPress as a backend.

It uses the power of the WordPress REST API to communicate back and forth from and to the database.

## Screenshots

### Desktop

![Desktop](https://cldup.com/xWuYKto1IQ.png)

### Mobile

![Mobile](https://cldup.com/lIG7Dd8VCO.png)

## TODO

- Do a logged out route when user is logged out (failing call in Boards)
- Do a quick fetch when trying to open the modal for creating a new item, so we know the user is logged in. If it fails, redirect to the "not logged in" route before writing in the modal.
- Add loggin check before editing an item.
