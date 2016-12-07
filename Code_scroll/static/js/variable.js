/*=================================================
true = enable
false = disable
1000 = 1 second

*** each var must have ; at the end of the line ***
=================================================*/

/*=================================================
preloader
=================================================*/

var __preloaderFadeOut = 1200; // fadeout
var __preloaderDelay = 800; // delay

/*=================================================
init config
=================================================*/

var __navigationToggle = true; // side nav toggle
var __recordHistory = false; // browser's history
var __scrollingSpeed = 1000; // page scroll speed

/*=================================================
background style, set only one of below to true
=================================================*/

var __staticBackground = true; // set background image by css
var __videoHeader = false; // video background toggle
var __slideshowHeader = false; // image background toggle

/*=================================================
overlay
=================================================*/

var __overlay = true; // overlay

/*=================================================
youtube video background
=================================================*/

var __youtubeUrl = 'https://www.youtube.com/watch?v=ZBVZAeGHIv8'; // youtube video url
var __videoStartTime = 1; // video start time, 70 mean 70 seconds
var __videoEndTime = 0; // video end time, 180 mean 180 seconds, 0 mean play to end
var __videoMute = true; // mute video on start

/*=================================================
slideshow background
=================================================*/

var __imageNumber = 1; // how many slideshow image to show, 1 for static image background
var __slideshowStatic = false; // true for fade effect slideshow, false for css3 effect slideshow
var __slideshowShuffle = false; // random image
var __slideshowDelay = 8000; // slideshow delay
var __slideshowTransitionDuration = 2500; // transition duration
var __slideshowAnimationDuration = 12000; // animation duration, __slideshowDelay + 2000 for better fadeout timing
var __slideshowAnimationSet = [ // animation effect set
        'kenburnsUp',
        'kenburnsDown',
        'kenburnsLeft',
        'kenburnsRight'
      ];
var __slideshowTransitionSet = [ // transition effect set
        'fade'
      ];

/*=================================================
background music
=================================================*/

var __audio = false; // audio background toggle

/*=================================================
countdown
=================================================*/

var __countdown = false; // countdown toggle
var __countdownDate = '09/26/2015 08:00:00'; // countdown date
var __countdownTimezone = '-3'; // timezone

/*=================================================
progress bar
=================================================*/

var __progressBarSpeed = 2000; // progress bar speed

/*=================================================
mailchimp
=================================================*/

var __mailChimpVersion = false; // mailchimp toggle, if disable, php version will enable
var __mailChimpUrl = 'MAILCHIMP_POST_URL_HERE'; // mailchimp post url

$.ajaxChimp.translations.eng = { // custom mailchimp message
  'submit': 'please wait',
  0: '<i class="fa fa-check"></i> email enviado',
  1: '<i class="fa fa-close"></i> entre com um e-mail válido',
  2: '<i class="fa fa-close"></i> e-mail inválido',
  3: '<i class="fa fa-close"></i> e-mail inválido',
  4: '<i class="fa fa-close"></i> e-mail inválido',
  5: '<i class="fa fa-close"></i> e-mail inválido'
}

// dedault message for reference

// Submit Message
// 'submit': 'Submitting...'
// Mailchimp Responses
// 0: 'We have sent you a confirmation email'
// 1: 'Please enter a value'
// 2: 'An email address must contain a single @'
// 3: 'The domain portion of the email address is invalid (the portion after the @: )'
// 4: 'The username portion of the email address is invalid (the portion before the @: )'
// 5: 'This email address looks fake or invalid. Please enter a real email address'

/*=================================================
***do not edit below code***
=================================================*/

if (__slideshowStatic) {
  var __slideshowAnimation = '';
  var __slideshowTransition = 'fade';
} else {
  var __slideshowAnimation = __slideshowAnimationSet;
  var __slideshowTransition = __slideshowTransitionSet;
}