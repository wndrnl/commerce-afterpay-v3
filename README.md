# Afterpay Payment Gateway plugin for Craft CMS 3.x
Adds Afterpay V3 support to Craft Commerce. Currently supports B2B/B2C for the following countries:
AT, BE, CH, DE, DK, FI, NL, NO, SE

This plugin is under development, once released a license can be purchased trough Craft's plugin store for 49,- dollars.

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require wndr/commerce-afterpay-v3

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Commerce Afterpay V3.

## Tax Id
For Afterpay, you have to provide a tax ID. Currently, we set our store ids to match theirs:
// 1 = high, 2 = low, 3, zero, 4 no tax

To allow for a mapping between the two is on the roadmap.

## License 
This plugin requires a commercial license purchasable through the Craft Plugin Store.

## commerce-afterpay-v3 Roadmap

Some things to do, and ideas for potential features:

* Release it
* Add refund functionality

Brought to you by [lenvanessen](wndr.digital)
