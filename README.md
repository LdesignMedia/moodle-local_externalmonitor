## Moodle - monitor webservice request and log them.
Monitor `/webservice/rest/server.php` and log in/outgoing. 
Used for debugging the Moodle external API.

## Author
![MFreak.nl](https://mfreak.nl/logo_small.png)

* Author: Luuk Verhoeven, [MFreak.nl](https://MFreak.nl/)
* Min. required: Moodle 3.0.x
* Supports PHP: 7.2

[![Build Status](https://travis-ci.org/MFreakNL/moodle-local_commander.svg?branch=master)](https://travis-ci.org/MFreakNL/moodle-local_commander)
![Moodle35](https://img.shields.io/badge/moodle-3.5-brightgreen.svg)
![Moodle36](https://img.shields.io/badge/moodle-3.6-brightgreen.svg)
![Moodle37](https://img.shields.io/badge/moodle-3.7-brightgreen.svg)
![Moodle38](https://img.shields.io/badge/moodle-3.8-brightgreen.svg)
![Moodle39](https://img.shields.io/badge/moodle-3.9-brightgreen.svg)
![Moodle310](https://img.shields.io/badge/moodle-3.10-brightgreen.svg)
![PHP7.2](https://img.shields.io/badge/PHP-7.2-brightgreen.svg)


## List of features
- Write logfile to `$CFG->tempdir\local_externalmonitor-`
- Replay same request with a `Curl` to allow getting the response data.
- @TODO page to realtime log monitor page.

## Installation
1.  Copy this plugin to the `local\externalmonitor` folder on the server
2.  Login as administrator
3.  Go to Site Administrator > Notification
4.  Install the plugin

## Security

If you discover any security related issues, please email [luuk@MFreak.nl](mailto:luuk@MFreak.nl) instead of using the issue tracker.

## License

The GNU GENERAL PUBLIC LICENSE. Please see [License File](LICENSE) for more information.

## Contributing

Contributions are welcome and will be fully credited. We accept contributions via Pull Requests on Github.
