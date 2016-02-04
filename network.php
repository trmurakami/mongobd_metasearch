<?php
  include ('inc/config.php');
  include ('inc/header.php');

?>
<title><?php echo gettext("branch");?> - Rede de colaboração entre instituições</title>
</head>
<body>
<?php include_once("inc/analyticstracking.php") ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.5&appId=90128977252";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php
  include ('inc/navbar.php');
?>

<div class="container">

  <!-- [...] -->
  <script src="sigmajs/sigma.min.js"></script>
  <script src="sigmajs/plugins/sigma.parsers.gexf.min.js"></script>
  <script>
    // Add a method to the graph model that returns an
    // object with every neighbors of a node inside:
    sigma.classes.graph.addMethod('neighbors', function(nodeId) {
      var k,
          neighbors = {},
          index = this.allNeighborsIndex[nodeId] || {};

      for (k in index)
        neighbors[k] = this.nodesIndex[k];

      return neighbors;
    });

    sigma.parsers.gexf(
      'export/instituicoes.gexf',
      {
        container: 'sigma-container'
      },
      function(s) {
        // We first need to save the original colors of our
        // nodes and edges, like this:
        s.graph.nodes().forEach(function(n) {
          n.originalColor = n.color;
        });
        s.graph.edges().forEach(function(e) {
          e.originalColor = e.color;
        });

        // When a node is clicked, we check for each node
        // if it is a neighbor of the clicked one. If not,
        // we set its color as grey, and else, it takes its
        // original color.
        // We do the same for the edges, and we only keep
        // edges that have both extremities colored.
        s.bind('clickNode', function(e) {
          var nodeId = e.data.node.id,
              toKeep = s.graph.neighbors(nodeId);
          toKeep[nodeId] = e.data.node;

          s.graph.nodes().forEach(function(n) {
            if (toKeep[n.id])
              n.color = n.originalColor;
            else
              n.color = '#eee';
          });

          s.graph.edges().forEach(function(e) {
            if (toKeep[e.source] && toKeep[e.target])
              e.color = e.originalColor;
            else
              e.color = '#eee';
          });

          // Since the data has been modified, we need to
          // call the refresh method to make the colors
          // update effective.
          s.refresh();
        });

        // When the stage is clicked, we just color each
        // node and edge with its original color.
        s.bind('clickStage', function(e) {
          s.graph.nodes().forEach(function(n) {
            n.color = n.originalColor;
          });

          s.graph.edges().forEach(function(e) {
            e.color = e.originalColor;
          });

          // Same as in the previous event:
          s.refresh();
        });
      }
    );
  </script>
  <!-- [...] -->
  <div id="sigma-container" class="sigma-container">
    <h3>Rede de colaboração entre as instituições (Incompleto, está somente com as afiliações identificadas)</h3>
  </div>


<?php
  include "inc/footer.php";
?>

</body>
</html>
