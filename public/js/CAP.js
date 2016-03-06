/**
 * Created by Eklect on 3/5/2016.
 */
jQuery(document).ready(function () {
  recog            = new webkitSpeechRecognition();
  recog.continuous = true;
  recog.lang       = 'en-US';
  recog.start();

  recog.onresult = function (event) {
    console.log(event.resultIndex);
  }
});