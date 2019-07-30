# module-pdfgenerator
By using Ecomteck Invoice PDF Generator, the user can download customized PDF printouts. The store owner can use the template system from our extension to customize the PDF print outs in the same way he can customize the email templates from the transactional emails. The biggest benefit of the PDF templates is the fact that you can choose the store the template is for. This system allows the store owner to personalize the invoice PDF printouts for each store. 

For example let's say you have a fashion store and a B2B store on the same installation. You will be able to make the invoice PDF printouts nice, with images and a lot of details for the normal store and very simple with SKU, prices, taxes and very narrow lines as they have a very large number of products per order. Also if the store owners marketing team wants to use different colors,fonts or layouts in the invoice printouts this can be accomplished very simple. You just need to know HTML and CSS to modify the look of your invoice PDF.

To use the system fast, you can load the body of the template from email templates under marketing in the "Template body" area in the PDF template and save. You need to set the template as enable and default for the store you desire. (remove the "body" tag from the email template before you paste the code).
## 1. Documentation

- [Installation guide](https://ecomteck.com/magento-2-tutorials/install-magento-2-extension/)
- [Download from our Live site](https://ecomteck.com/downloads/magento-2-pdf-generator/)
- [Get Free Support](https://ecomteck.com/ask-question/)
- [Get Custom Work](https://ecomteck.com/contact)

## 2. How to start to use the PDF generator

Add a new template from the "Add new template" button. This will prompt you with a set of fields. 

- Enable template - you need to enable the template in order to use it;
- Default template - make the template as default for the current store;
- Template name - this is for your own information as well as the template description;
- Template for website - here you select the website you need the template for;
- The template body, header and footer is where you can add the html that will be transformed into the PDF body;
- The template CSS filed allows you to create styles for the html like "h1 {color:red;} h2 {color:blue}", do not use the style tag, it is not need. In the - body you can also specify html like in the email templates;
- The template settings are used to shape the template as you need. The "Template file name" can be made from variables as long as they are ok for file naming {{var invoice.increment_id}}-{{var invoice.id}}-file-invoice. The "Template paper orientation" is used to set the pdf as landscape or portrait.  If you chose to use the custom format the "Custom height" and "Custom width" in millimeters will be used. The paper orientation and the "Template paper format" will be ignored in this case. If the template has standard format the "Template paper format" will allow you to set the paper in a few formats (A4,A5,A3,Letter and Legal). The other settings are the margins (in millimeters) for the top, right, left and bottom. If the header or footer overlaps over your body increase the top and bottom margins to fix this. 

## 3. How to install


## ✓ Install via composer (recommend)
Run the following command in Magento 2 root folder:

```
composer require ecomteck/module-pdfgenerator
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy -f
php bin/magento cache:clean
```

## Conclusion

The extension will allow you to harness all the power of the email template system and more. You can add phtml files to your template for very advanced configurations ({Error in template processing} and {Error in template processing}).  You can add your own item processing layout so you can output taxes item prices as you want ({{layout area="frontend" handle="sales_email_order_invoice_items" invoice=$invoice order=$order}}).

You can also localize your template using the trans directive. {{trans "Thank you for your order from %store_name." store_name=$store.getFrontendName()}}{{trans "Once your package ships we will send you a tracking number."}}

Using the extension you are able to change the invoice PDF as you desire. The PDF Generator has multiple features as follows:

- change the Magento invoice PDF to meet your needs;
- add custom CSS to your template to further personalize the PDF;
- add templates for each store with different design and features;
- change the file name of the PDF file using variables;
- you can send the invoice as PDF attachment to the invoice mail;
- you can disable enable the PDF from the system configuration area.

**People also search:**
- Invoice PDF
- pdf generator
- magento 2 pdf generator
- frontend generate pdf
- pdf invoice for magento 2
- order pdf magento 2 extension
- print invoice extension
- pdf generator magento 2 extension


**Other free extension on Github**
- [Magento 2 Order Comments](https://github.com/ecomteck/magento2-order-comments)
- [Magento 2 Social Login](https://github.com/ecomteck/magento-2-social-login)

