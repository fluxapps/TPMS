This is an open source project by fluxlabs ag, CH-Aetingen (https://fluxlabs.ch)

## Installation

### Install TPMS-Plugin
Start at your ILIAS root directory
```bash
mkdir -p Customizing/global/plugins/Services/Cron/CronHook
cd Customizing/global/plugins/Services/Cron/CronHook
git clone https://github.com/fluxapps/TPMS.git TPMS
```
Update, activate and config the plugin in the ILIAS Plugin Administration

### Requirements
* ILIAS 6 & ILIAS 7
* PHP >=7.0

### Environment Variables
- TPMS_SFTP_HOST=000.000.000.000;
- TPMS_SFTP_USER=abc;
- TPMS_SFTP_PASSWORD=abc;