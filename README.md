## Moodle - monitor webservice request and log them.
Monitor `/webservice/rest/server.php` and log in/outgoing. Used for debugging purposes.

## Author
![MFreak.nl](https://mfreak.nl/logo_small.png)

* Author: Luuk Verhoeven, [MFreak.nl](https://MFreak.nl/)
* Min. required: Moodle 3.0.x
* Supports PHP: 7.2

![Moodle39](https://img.shields.io/badge/moodle-3.9-brightgreen.svg)
![Moodle310](https://img.shields.io/badge/moodle-3.10-brightgreen.svg)
![Moodle311](https://img.shields.io/badge/moodle-3.11-brightgreen.svg)
![PHP7.2](https://img.shields.io/badge/PHP-7.2-brightgreen.svg)

## List of features
- For now you can only monitor webservice calls.
- Write to a logfile in `$CFG->tempdir\local_externalmonitor\`
- Replay same request with a new `Curl` request to allow getting the response data for logging.
- Viewing logs `/local/externalmonitor/view/logs.php`
- Restrict access with capability 'local/externalmonitor:logs'
- Cleans previous logs from previous days automatically.


## Installation
1.  Copy this plugin to the `local\externalmonitor` folder on the server
2.  Login as administrator
3.  Go to Site Administrator > Notification
4.  Install the plugin

## Usage

After installation, you can view the webservice in/out traffic on `/local/externalmonitor/view/logs.php`
This will display log entries like below:

![](pix/screen.png)

## Security

If you discover any security related issues, please email [luuk@MFreak.nl](mailto:luuk@MFreak.nl) instead of using the issue tracker.

## License

The GNU GENERAL PUBLIC LICENSE. Please see [License File](LICENSE) for more information.

## Contributing

Contributions are welcome and will be fully credited. We accept contributions via Pull Requests on Github.
