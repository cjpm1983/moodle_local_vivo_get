# Get from VIVO #

This plugin allow Moodle to retrieve Metadata from VIVO CRIS servers [`https://vivo.lyrasis.org`](https://vivo.lyrasis.org/)

![alt text](https://github.com/cjpm1983/moodle_local_vivo_get/blob/main/img/vivo.png?raw=true)

it provides an interface for configuring the url of the server as well as credentials

![alt text](https://github.com/cjpm1983/moodle_local_vivo_get/blob/main/img/settings.png?raw=true)

then it will retrieve the needed Metadata by executing SparQl queries.

![alt text](https://github.com/cjpm1983/moodle_local_vivo_get/blob/main/img/metadata.png?raw=true)


## Installing via uploaded ZIP file ##

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/local/vivo_get

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## License ##

2022 Carlos J. Palacios <cjpm1983@gmail.com>

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.
