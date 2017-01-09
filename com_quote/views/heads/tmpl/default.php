<?php 
  defined('_JEXEC') or die;

  $document = JFactory::getDocument();

  $document->addScript('components/com_quote/views/heads/tmpl/js/jquery.js');

  $document->addScript('components/com_quote/views/heads/tmpl/js/materialize/js/materialize.js');

  $document->addScript('components/com_quote/views/heads/tmpl/js/quoteAdmin.js');

  $document->addScript('components/com_quote/views/heads/tmpl/js/app.js');

?>
<jdoc:include type="head"/>
<html lang="en">
<body>
<!-- ______________________________Admin tab___________________________ -->
  <div class="container3">
    <div class="container">
      Select Quote by:
      <div class="row">
        <div class="col s1 m1">
          <label for="q1">
            <input id="q1" type="radio" name="q">
            # Quote
          </label>
        </div>
        <div class="col s1 m1">
          <label for="q2">
            <input id="q2" type="radio" name="q">
            User
          </label>
        </div>
        <div class="col s1 m1">
          <label for="q3">
            <input id="q3" type="radio" name="q">
            State
          </label>
        </div>
      </div>

      <div class="row">
        <div class="col s2 m2">   
          <label id="quote_r" for="quote_request">
          </label>
        </div>
      </div>
      
      <div class="row">
        
        <div class="searchResult"></div>
          <div class="table-responsive col s12 m6 sendTableMail">
            <table class="table table-condensed table-bordered QTable" style="display:none;" id="ITable">
              <thead>
                <tr>
                  <th class="center-align">#</th>
                  <th class="center-align">Brand</th>
                  <th class="center-align">Part</th>
                  <th class="center-align">Qnty</th>
                  <th class="center-align">Price</th>
                </tr>
              </thead>
              <div class="mssgResult x" style="display:none;">
                There's not price for these products.
              </div>
              <tbody id="itemTabla"></tbody>  
            </table>
          </div>
      </div>
    </div>
    <div class="mssgUpdate"></div>
    <div class="mssgMailUpdate"></div>
    <button style="display:none;" class="btnUpdate button-secondary">Send to Customer</button>
    <div class="copyTable" style="display:none;"></div>
  </div>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js"></script>
