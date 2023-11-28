<div id="siteBanner">
  <img src="../src/img/banner_full.webp" alt="site banner" width="100%">
</div>

<main>
  <div class="home_qualities container-fluid">
    <h2>Our qualitites</h2>
    <button id='ajax_qualitiesBtn' onclick="displayQualities()">
      <i class="fa fa-plus"></i>  
      Show qualities (lab 3.3.1)
    </button>
    <ul class="d-none" id="ajax_qualities"></ul>
  </div>

  <div class="home_categories container-fluid">
    <h2>Shop by Categories</h2>
    <h1 id="arrayData"></h1>
  </div>

  <div class="home_deals container-fluid">
    <h2>Great deals !</h2>
    <h1 id="arrayData"></h1>
  </div>

  <script src="./scripts/ajax.js"></script>

</main>
