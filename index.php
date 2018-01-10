<?php
require 'helpers/helper.php';
function start()
{
//$db = connect();
  getHeader();
  echo '<script  type="text/javascript">
  jQuery(document).ready(function($)
  {
      $(".clickable-row").click(function()
      {
          window.document.location = $(this).data("href");
      });
  });
  </script>';
  echo "<title> CARD$ - A Card Pricing Project </title>";
  if (isset($_GET["page"]))
  {
    $page  = $_GET["page"];
  }
  else
  {
    $page=1;
  }
  $results_per_page = 20;
  $conn = connect();
  $start_from = ($page-1) * $results_per_page;
  $sql = "SELECT * FROM Magic_Cards ORDER BY CardName ASC LIMIT $start_from, ".$results_per_page;
  $rs_result = $conn->Execute($sql);
  if (!$rs_result)
    print $conn->ErrorMsg();
  else
  {
    echo '<div align="center">';
    $total_pages = ceil(500 / $results_per_page); // calculate total pages with results
    $previous = $page-1;
    print '<nav aria-label="Page navigation">
          <ul class="pagination">
          <li';
    if ($page == 1)
      print ' class="disabled"><a href="" aria-label="Previous">';
    else
      print '><a href="?page='.$previous.'" aria-label="Previous">';
    print '<span aria-hidden="true">&laquo;</span>';
    print'</a>
          </li>';
    for ($i=1; $i<=$total_pages; $i++)
    {  // print links for all pages
      print '<li><a href="?page='.$i.'"';
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
    print '><a href="?page='. $next .'" aria-label="Next">';
    }
    print '<span aria-hidden="true">&raquo;</span>';
    print '</a>
           </li>
           </ul>
           </nav>';
    // if ($page != 1)
    // {
    //   $previous = $page-1;
    //   echo "<a href='?page=1'> &#60&#60 </a>";
    //   echo "<a href='?page=".$previous."'> &#60 </a>";
    // }
    // for ($i=1; $i<=$total_pages; $i++)
    // {  // print links for all pages
    //         echo "<a href='?page=".$i."'";
    //         if ($i==$page)
    //           echo " style='background-color:#ffffa0'";
    //         echo ">".$i."</a> ";
    // }
    // if ($page != $total_pages)
    // {
    //   $next = $page+1;
    //   echo "<a href='?page=".$next."'> &#62 </a>";
    //   echo "<a href='?page=".$total_pages."'> &#62&#62 </a>";
    // }
    echo '<div>'.
         '<form action="search.php" method="GET">'.
         '<input type="text" name="query" />'.
         '<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Search</button>'.
         '</form>'.
         '<br>'.
         '</div>';
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
         '</style>';
    echo '<table border="1" cellpadding="4">
          <thead>
          <tr>
          <td bgcolor="#213b66" align = "center"><strong>Name</strong></td>
          <td bgcolor="#213b66" align = "center"><strong>Description</strong></td>
          <td bgcolor="#213b66" align = "center"><strong>Rarity</strong></td>
          <td bgcolor="#213b66" align = "center"><strong>Set Name</strong></td>
          </tr>'.
          '</thead>'.
          '<tbody>';
    $x = 0;
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
  print "</tbody></table>";

  }
  $previous = $page-1;
  print '<nav aria-label="Page navigation">
        <ul class="pagination">
        <li';
  if ($page == 1)
    print ' class="disabled"><a href="" aria-label="Previous">';
  else
    print '><a href="?page='.$previous.'" aria-label="Previous">';
  print '<span aria-hidden="true">&laquo;</span>';
  print'</a>
        </li>';
  for ($i=1; $i<=$total_pages; $i++)
  {  // print links for all pages
    print '<li><a href="?page='.$i.'"';
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
  print '><a href="?page='. $next .'" aria-label="Next">';
  }
  print '<span aria-hidden="true">&raquo;</span>';
  print '</a>
         </li>
         </ul>
         </nav>'.
        '</div>';
  getFooter();
  return;
}
start();
?>