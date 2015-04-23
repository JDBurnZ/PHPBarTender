PHPBarTender
============

A lightweight PHP interface for generating XML jobs compatible with Seagull Scientific's BarTender Barcode Label Software

Instantiating a BarTender Object
-
<pre>
&lt;?php
require 'bartender.class.php';

$label = 'C:\\some\\path\\to\\label.btw'; // Local path
// OR...
$label = '\\\\some-server\\some\\share\\label.btw'; // Shared path

$printer = 'SomeLocalPrinter'; // Local printer
// OR...
$printer = '\\\\some-server\\some-shared-printer'; // Network printer

// Instantiate the BarTender Object
$bartender = new BarTender($label, $printer);
</pre>

Generate and return an XML string
-
<pre>
$labels = array(
  array ( // First label
    'FieldName1' => 'FieldValue123',
    'FieldName2' => 'FieldValue234'
  ,
  array ( // Second label
    'FieldName1' => 'FieldValue345',
    'FieldName2' => 'FieldValue456'
  )
);
$xml = $bartender->generateToReturn($labels);
</pre>


Generate XML and save to disc
-
<pre>
$labels = array(
  array ( // First label
    'FieldName1' => 'FieldValue123',
    'FieldName2' => 'FieldValue234'
  ,
  array ( // Second label
    'FieldName1' => 'FieldValue345',
    'FieldName2' => 'FieldValue456'
  )
);
$filename = '/path/to/file.xml';
$bartender->generateToFile($labels, $filename);
</pre>


Donations
---------
PHPBarTender is free software, but donations help the developer spend more time maintaining this projects and others like it.
<br />
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S42X58PL8SR2Y"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" /></a>
