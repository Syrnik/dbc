Delivery Paid on Receipt — Shop-Script Plugin
===============================================

[Русская версия](README.md)

The plugin hides the shipping cost from the online payment total: the customer pays only for the goods online
and pays for the delivery to the courier upon receiving the order.

When an order is created or edited, the plugin zeroes out the shipping cost and stores the original amount in
an internal order parameter. The order total is recalculated accordingly. Zeroing is applied only for the
shipping and payment method combinations selected in the plugin settings. The saved shipping cost is displayed
in the backend on the order page.

Order creation notifications are sent before the plugin runs, so the customer's email will contain the original
total including shipping. The plugin does not affect the shipping cost displayed during checkout — it only
takes effect after the order is placed.

## Requirements

- PHP 7.4 or later
- Webasyst Framework (installer) 3.0 or later
- Shop-Script 8.0 or later (8.17 for helper support)

A Smarty helper is available to retrieve the saved shipping cost:
`{$wa->shop->dbcPlugin->shippingCost($order)}`. The method accepts an order ID, an order data array, or a
`shopOrder` object. Requires Shop-Script 8.17 or later.
