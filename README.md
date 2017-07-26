Author:                 King Bradley
Editors:                ZX Chen
Contributors:           King Bradley, Gibsern, ZX Chen
Latest Edited date:     09 Dec 2015
Opencart version:       2.0.3.1
Boilerplate version:    2.1.7

Customer Login Credentials
+---------------+-----------------------+-----------------------+
| Role	       	|	Username	        |	password            |
+---------------+-----------------------+-----------------------+
| Default	    |	test@test.com	    |	test                |
+---------------+-----------------------+-----------------------+

Admin Login Credentials
+---------------+-----------------------+-----------------------+
| Role		    |	Username	        |	Password            |
+---------------+-----------------------+-----------------------+
| Developer	    |	developer           |	password            |
| Administrator	|	firstcom            |	password            |
+---------------+-----------------------+-----------------------+

Helper - Functions (system/helper/functions.php)
--------------------------------------------------------------
- debug($array);
- debugInfo($array);
- requestServer();
- sendMail($to, $from, $sender, $subject, $html, $text, $admin);
- generateSlug($phrase);

Image - Zoom Functions (system/library/image)
--------------------------------------------------------------
- zoomin($path, $width, $height); 
- byheight($path, $width, $height); 
- bywidth($path, $width, $height);

CSS - Non-Responsive
--------------------------------------------------------------
- Uncomment this to make the website unresponsive at the top of 
  the stylesheet.css, use extra-small columns in the html for 
  non-responsive website
  body, .container, header, footer, #top {
	min-width: 1130px;
  }
  .container {
	max-width: 1130px;
  }
- Navbar with N-level dropdown menu, sample code below
	<ul class="nav navbar-nav">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">PARENT</a>
			<div class="dropdown-menu">
				<div class="dropdown-inner">
					<ul class="list-unstyled">
						<li class="dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">CHILD</a>
							<div class="dropdown-menu">
								<div class="dropdown-inner">
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</li>
	</ul>


Changelog
--------------------------------------------------------------
09 Dec 2015 - v2.1.7
--------------------------------------------------------------
- Add X Payment module
- Add Testimonial module
- Add curlopt_userpwd for fixing curl bug
- Update featured module heading title
- Fix hide dashboard menu for common/newspanel at backend dashboard
- Fix path_replace bugs
- Fix bugs pick up multiple locations
- Fix hidemenu for testimonial module
- Fix turbo bugs
- Fix double slashs

--------------------------------------------------------------
02 Dec 2015 - v2.1.6
--------------------------------------------------------------
- Add optimization for performance
- Add path replacement for domain migration
- Add Zopim default code
- Add a Geo Zone for all countries beside Singapore
- Add fa-1 to fa-6 default font size
- Add Layout for gallery images and gallery category
- Update slideshow module
- Update font awesome to v4.5

--------------------------------------------------------------
26 Nov 2015 - v2.1.5
--------------------------------------------------------------
- Add Tabs module
- Add n-level gallery categories
- Add email to store location
- Add custom font size and line height at ckeditor
- Add header for cart inside quick checkout page
- Add SEO for product categories
- Change recatpcha warning message
- Fix filemanager upload image with backslash path at localhost
- Fix order history permission problem
- Fix permission issue
- Fix hidemenu module (xml file)
- Update Formula-based shipping module
- Enhance multiple locations pick up

--------------------------------------------------------------
20 Nov 2015 - v2.1.4
--------------------------------------------------------------
- Fix misalignment of icon and cart-total
- Add html_entity_decode for attribute text
- Add google recaptcha status, secret and public key for localhost

--------------------------------------------------------------
17 Nov 2015 - v2.1.3
--------------------------------------------------------------
- Add checking for content_header and content_fooder
- Add payment fees and discounts
- Add facebook, twitter and instagram with icon to the frontend
- Add checking for banner.tpl when there is only one banner
- Add display news article additional description when there is content at backend

--------------------------------------------------------------
17 Nov 2015 - v2.1.2
--------------------------------------------------------------
- Add menu
- Fix automated config path

--------------------------------------------------------------
16 Nov 2015 - v2.1.1
--------------------------------------------------------------
- Add home and contact to top navigation bar

--------------------------------------------------------------
16 Nov 2015 - v2.1
--------------------------------------------------------------
- Installation of Form builder pro
- Installation of manufacturer module
- Add mailchimp API Key
- Add paypal express credentials
- Add contact form with additional emails
- Add category title and breadcrumb with/without path at product page
- Add a function to retrieve parts when there is no path
- Add clear both and focus outline none
- Add active for category at top
- Add default css breakpoint
- Add all products
- Add bootstrap text center, right, left and justift for different size of columns
- Add bootstrap equal height columns (catalog/view/theme/default/stylesheet/bootstrap-equal-height)
- Add automated config path
- Add N-level dropdown submenu
- Add description for banner
- Add default placeholder stylesheet
- Add default customer
- Add css for non-responsive
- Add all layouts for integrating modules
- Fix select none zone when country singapore is selected
- Fix mailchimp error when updating admin > sales > customer
- Fix coupon bugs
- Fix radio button style
- Modify page class
- Modify CKEditor
- Modify free checkout module
- Modify the checkbox position
- Hide download message from success
- Remove return function from order history

--------------------------------------------------------------
01 Oct 2015 - v2.0
--------------------------------------------------------------
- Change owl carousel slider to Masterslider
- Masterslider with layout and slide transitions selection
- Installation of vqMod
- Installation of news and blogs
- Installation of gallery module
- Installation of newsletter with MailChimp integration
- Installation of quick checkout
- Installation of power image manager
- Installation of CKEditor
- Installation of formula-based shipping
- Installation of multiple locations for pickup from store
- Installation of FAQ management
- Installation of eNets payment
- Installation of Zopim live chat
- Auto-generate SEO keyword
- Social media inputs (i.e. Facebook, Twitter, Instagram) at system setting
- Access control and hide admin menu based on granted permission
- Super user account (developer) for admin panel
- Add logo and favicon for admin panel
- Add contact number at contact us page
- Add email address and Google map at contact us page
- Add zoom in image function
- Add CC and BCC email functionality
- Add content header, content middle, and content footer layouts
- Add in self-defined functions for debugging purpose, generate SEO keyword, and send email
- Pre-configured system setting for country, tax, language, currency, etc.
- Change attribute textarea to CKEditor