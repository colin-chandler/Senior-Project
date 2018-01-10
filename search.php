<?php
require_once 'helpers/helper.php';
getHeader();
echo '<style type="text/css">'.
     'tr:hover td {'.
     'background-color: #1e90ff;'.
     'cursor: pointer;'.
     '}'.
     'thead td{'.
     'background-color: #213b66;'.
     'color: #FFFFFF;'.
     '}'.
     'thead tr:hover td {'.
     'background-color: #213b66;'.
     'color: #FFFFFF;'.
     'cursor: default;'.
     '}'.
     'table {'.
     'max-width: 80%;'.
     'max-height: 10%;'.
     'text-overflow: ellipsis;'.
     '}'.
     '</style>';
echo '<script  type="text/javascript">
     jQuery(document).ready(function($)
     {
         $(".clickable-row").click(function()
         {
             window.document.location = $(this).data("href");
         });
     });
     </script>';
$conn = connect();

$query = $_GET['query'];
       // gets value sent over search form
if (isset($_GET["page"]))
  {
    $page  = $_GET["page"];
  }
else
  {
    $page=1;
  }
  echo '<title> CARD$ - Searching for "'. $query .'"</title>';
$min_length = 0;
       // you can set minimum length of the query if you want

if(strlen($query) >= $min_length)
  { // if query length is more or equal minimum length then
    $query = htmlspecialchars($query);
           // changes characters used in html to their equivalents, for example: < to &gt;
    // $query = mysql_real_escape_string($query);
           // makes sure nobody uses SQL injection
    $results_per_page = 20;
    $start_from = ($page-1) * $results_per_page;
    $totalsql = "SELECT * FROM Magic_Cards WHERE (`CardName` LIKE '%".$query."%') OR (`CardSet` LIKE '%".$query."%')";
    $sql = "SELECT * FROM Magic_Cards WHERE (`CardName` LIKE '%".$query."%') OR (`CardSet` LIKE '%".$query."%') ORDER BY CardName ASC LIMIT $start_from, ".$results_per_page;
    $totalconn = totalHelp();
    $total_result = mysql_query($totalsql, $totalconn);
    $rs_result = $conn->Execute($sql) or die(mysql_error());

           // * means that it selects all fields, you can also write: `id`, `title`, `text`
           // articles is the name of our table

           // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
           // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
           // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'
           echo '<div align="center">';
           $total = mysql_num_rows($total_result);
           $total_pages = ceil($total / $results_per_page); // calculate total pages with results
           $previous = $page-1;
           print '<nav aria-label="Page navigation">
                 <ul class="pagination">
                 <li';
           if ($page == 1)
             print ' class="disabled"><a href="" aria-label="Previous">';
           else
             print '><a href="search.php?query='.$query.'&page='.$previous.'" aria-label="Previous">';
           print '<span aria-hidden="true">&laquo;</span>';
           print'</a>
                 </li>';
           for ($i=1; $i<=$total_pages; $i++)
           {  // print links for all pages
             print '<li><a href="search.php?query='.$query.'&page='.$i.'"';
             if ($i == $page)
               print ' style="background-color:#1e90ff; color:#ffffff"';

             print '>'.$i.'</a></li>';
           }
           $next = $page+1;
           print '<li';
           if ($page == $total_pages)
           {
             print ' class="disabled"><a href="" aria-label="Next">';
           }
           elseif ($total_pages == 0)
           {
             print ' class="disabled"><a href="" aria-label="Next">';
           }
           else
           {
           print '><a href="search.php?query='.$query.'&page='. $next .'" aria-label="Next">';
           }
           print '<span aria-hidden="true">&raquo;</span>';
           print '</a>
                  </li>
                  </ul>
                  </nav>';
           echo '<div>'.
                '<form action="search.php" method="GET">'.
                '<input type="text" name="query" />'.
                '<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Search</button>'.
                '</form>'.
                '<br>'.
                '</div>';
    if(!$rs_result->fields)
      { // if there is no matching rows do following
        echo "No results";
      }
    else
      { // if one or more rows are returned do following
        echo '<table border="1" cellpadding="4">
              <thead>
              <tr>
              <td bgcolor="#213b66"><strong>Name</strong></td>
              <td bgcolor="#213b66"><strong>Description</strong></td>
              <td bgcolor="#213b66"><strong>Rarity</strong></td>
              <td bgcolor="#213b66"><strong>Set Name</strong></td>
              </tr></thead>';
        while($rs_result->fields)
        {
          #$rs_result->fields[1]. ' ' .$rs_result->fields[2]. ' ' .$rs_result->fields[3]. ' ' .$rs_result->fields[4];
          $cardID = $rs_result->fields[0];
          $name = $rs_result->fields[1];
          $desc = $rs_result->fields[2];
          $rare = $rs_result->fields[3];
          if ($rare == 1)
          {
            $rarity = "Common";
          }
          elseif($rare == 2)
          {
            $rarity = "Uncommon";
          }
          elseif($rare == 3)
          {
            $rarity = "Rare";
          }
          elseif($rare == 4)
          {
            $rarity = "Mythic Rare";
          }
          $set = $rs_result->fields[4];
          echo "<tr class='clickable-row' data-href='card.php?cardID=".$cardID."' height='50'>".
               "<td align='center'>".$name."</td>";
          echo "<td>".$desc."</td>";
          echo "<td align='center' style='width:100px'>".$rarity."</td>".
               "<td align='center' style='width:100px'>".$set."</td>".
               "</tr>";
          $rs_result->MoveNext();
        }
        echo "</table>";
        $previous = $page-1;
        print '<nav aria-label="Page navigation">
              <ul class="pagination">
              <li';
        if ($page == 1)
          print ' class="disabled"><a href="" aria-label="Previous">';
        else
          print '><a href="search.php?query='.$query.'&page='.$previous.'" aria-label="Previous">';
        print '<span aria-hidden="true">&laquo;</span>';
        print'</a>
              </li>';
        for ($i=1; $i<=$total_pages; $i++)
        {  // print links for all pages
          print '<li><a href="search.php?query='.$query.'&page='.$i.'"';
          if ($i == $page)
            print ' style="background-color:#1e90ff; color:#ffffff"';
          print '>'.$i.'</a></li>';
        }
        $next = $page+1;
        print '<li';
        if ($page == $total_pages)
        {
          print ' class="disabled"><a href="" aria-label="Next">';
        }
        else
        {
        print '><a href="search.php?query='.$query.'&page='. $next .'" aria-label="Next">';
        }
        print '<span aria-hidden="true">&raquo;</span>';
        print '</a>
               </li>
               </ul>
               </nav>';
        print '</div>';
        getFooter();
        return;
      }
  }
  else
    { // if query length is less than minimum

    }
getFooter();
?>