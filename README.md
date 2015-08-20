# Sac
A web app to manage tiny conferences. It allows administrators to manage payments, schedules, attendance lists, competitions, rooms, etc. Visitors can book the events they want to participate.

![sac_screenshot](https://cloud.githubusercontent.com/assets/512405/9394995/f7962954-4761-11e5-9e9e-4a509f0cead5.png)

## Motivation

Sac was born out of the need of managing students for an annual event at the [Computer Science course at UFFS](http://cc.uffs.edu.br). We needed an easy to use app to manage payments, attendance lists, booking, etc. It was easier (and funnier) to create our own solution than to learn an existing one.

## Installation

Clone the repo to your web document root (e.g. `/var/www/sac`). Create a MySQL database and populate it with the content of [inc/resources/sac.sql](https://github.com/Dovyski/Sac/blob/master/inc/resources/sac.sql). Finally change the file `inc/config.php` to fit your needs, like the database name/user/password. You're good to go!

## Contributors

If you liked the project and want to help, you are welcome! Submit pull requests or [open a new issue](https://github.com/Dovyski/Sac/issues) describing your idea.

## License

Sac is licensed under the MIT license.
