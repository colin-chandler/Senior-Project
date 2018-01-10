<?php
require_once 'helpers/helper.php';
getHeader();
print '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/jquery.jqplot.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/plugins/jqplot.canvasTextRenderer.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/plugins/jqplot.canvasAxisTickRenderer.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/plugins/jqplot.dateAxisRenderer.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/plugins/jqplot.dateAxisRenderer.min.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/plugins/jqplot.canvasAxisLabelRenderer.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/plugins/jqplot.logAxisRenderer.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/plugins/jqplot.logAxisRenderer.min.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/plugins/jqplot.highlighter.js"></script>'.
'<script type="text/javascript" src="js/JQPlot/plugins/jqplot.cursor.js"></script>'.
'<link rel="stylesheet" type="text/css" href="js/JQPlot/jquery.jqplot.css" />';
echo '<style type="text/css">'.
     'table td {'.
     'background-color: #213b66;'.
     'color: #FFFFFF;'.
     '}'.
     '</style>';
date_default_timezone_set('America/Chicago');
$startFoundCK = False;
$startFoundTCG = False;
// $debug = [];
if (isset($_GET["cardID"]))
{
  $card  = $_GET["cardID"];
}
$conn = connect();
$sql = "SELECT * FROM `Magic_Cards` WHERE CardID = ". $card;
$card_info_result = $conn->Execute($sql);
if (!$card_info_result)
{
  print $conn->ErrorMsg();
}
else
{
  //$card_info_result (Name, Description, Rarity, Set)

  foreach ($card_info_result as $cardInfo)
  {
    //make a usable array to use
  }
  $cardName = $cardInfo[1];
  $cardDescription = $cardInfo[2];
  if ($cardDescription == "")
  {
    $cardDescription = "No Description.";
  }
  $rare = $cardInfo[3];
  $cardSet = $cardInfo[4];
  if ($rare == 1)
  {
    $cardRarity = "Common";
  }
  elseif($rare == 2)
  {
    $cardRarity = "Uncommon";
  }
  elseif($rare == 3)
  {
    $cardRarity = "Rare";
  }
  elseif($rare == 4)
  {
    $cardRarity = "Mythic Rare";
  }
  print '<div style="width: 100%;">'.
        '<div style="float: left; width: 5%;">'.
        '</br></div>'.
        '<div style="float: left; width: 45%; height: 50%; padding-right: 5em">';
  print '<table border="1" cellpadding="4" width="100%">'.
        '<tr>'.
        '<td bgcolor="#CCCCCC" height = "30"><strong>'. $cardName .'</strong></td>'.
        '</tr>'.
        '<tr>'.
        '<td bgcolor="#CCCCCC" height = "30"><strong>'. $cardDescription .'</strong></td>'.
        '</tr>'.
        '<tr>'.
        '<td bgcolor="#CCCCCC" height = "30"><strong>'. $cardRarity .'</strong></td>'.
        '</tr>'.
        '<tr>'.
        '<td bgcolor="#CCCCCC" height = "30"><strong>'. $cardSet .'</strong></td>'.
        '</tr>'.
        '</table></div>';
     // '<div style="float: left; width: 30%;">Prices</div>'.
     // '<div style="float: left; width: 30%;">Historic Price Stuff Stuff</div>'.
     // '<div style="float: left; width: 5%;"></div>';
  $sql = "SELECT * FROM `Card_Prices` WHERE CardID = ". $card;
  $price_result = $conn->Execute($sql);
  if (!$price_result)
  {
    print $conn->ErrorMsg();
  }
  else
  {
    //$price_result (currentPrice)
    foreach ($price_result as $prices)
    {
      //make a usable array to get prices
    }
    $CardKingdomPrice = $prices[1];
    // $TCGPlayerPrice = $prices[2];
    $TrollAndToadPrice = $prices[3];
    $ToyWizPrice = $prices[4];
    $AbuGamesPrice = $prices[5];
    $sql = "SELECT * FROM `Magic_Cards_Historic_Prices` WHERE CardID = ". $card;
    $historic_result = $conn->Execute($sql);
    if (!$historic_result)
    {
      print $conn->ErrorMsg();
    }
    else
    {
      print '<script>';
      print "$(function(){";
            //  var line = [";
      //SELECT * FROM  `Historic_Prices` WHERE HistoricID =1 AND SourceID =1
      // foreach ($historic_result as $id)
      // {
      //   $HID = $id[1];
      //   $sql = "SELECT * FROM (SELECT * FROM  `Historic_Prices` WHERE HistoricID =". $HID ." AND SourceID = 1 ORDER BY HistoricID DESC LIMIT 20) tmp ORDER BY tmp.HistoricID ASC";
      //   $hTCGPrice_result = $conn->Execute($sql);
      //   foreach ($hTCGPrice_result as $hTCGPrice)
      //   {
      //     //hTCGPrice[1] == price
      //     //hTCGPrice[3] == date
      //     $pulledDate = $hTCGPrice[3];
      //     // if (!$startFoundTCG)
      //     // {
      //     //   $startDateTimeTCG = new DateTime($pulledDate);
      //     //   date_add($startDateTimeTCG, date_interval_create_from_date_string('-1 days, -1 hours'));
      //     //   $startDateTCG = date_format($startDateTimeTCG, 'F j, Y g:i A');
      //     //   $startFoundTCG = True;
      //     // }
      //     $dateTime = new DateTime($pulledDate);
      //     date_add($dateTime, date_interval_create_from_date_string('-1 hours'));
      //     $date = date_format($dateTime, 'Y-m-d g:i A');
      //     print "['" .$date ."', ". $hTCGPrice[1] ."],";
      //   }
      //   //when I make the scrapers for these sites I can uncomment these lines \/\/\/\/
      //   // $sql = "SELECT * FROM  `Historic_Prices` WHERE HistoricID =". $HID ." AND SourceID = 2";
      //   // $hTrollAndToadPrice_result = $conn->Execute($sql);
      //   // $sql = "SELECT * FROM  `Historic_Prices` WHERE HistoricID =". $HID ." AND SourceID = 3";
      //   // $hAbuGamesPrice_result = $conn->Execute($sql);
      //   // $sql = "SELECT * FROM  `Historic_Prices` WHERE HistoricID =". $HID ." AND SourceID = 4";
      //   // $hToyWizPrice_result = $conn->Execute($sql);
      // }
      // $date = date_format($dateTime, 'F jS, Y g:i A');
      // $lastUpdateTCG = $date;
      // $dateTime = new DateTime();
      // $date = date_format($dateTime, 'Y-m-d g:i A');
      // print "['". $date ."', ". $TCGPlayerPrice ."]];";
      $sql = "SELECT * FROM `Magic_Cards_Historic_Prices` WHERE CardID = ". $card;
      $historic_result = $conn->Execute($sql);
      if (!$historic_result)
      {
        print $conn->ErrorMsg();
      }
      else
      {
        print "var line = [";
        foreach ($historic_result as $id)
        {
          $HID = $id[1];
          // $debug = $id[1];
          $sql = "SELECT * FROM  `Historic_Prices` WHERE HistoricID =". $HID ." AND SourceID = 5";
          $hCardKingdomPrice_result = $conn->Execute($sql);
          foreach ($hCardKingdomPrice_result as $hCardKingdomPrice)
          {
            $pulledDate = $hCardKingdomPrice[3];
            // if (!$startFoundCK)
            // {
            //   $startDateTimeCK = new DateTime($pulledDate);
            //   date_add($startDateTimeCK, date_interval_create_from_date_string('-1 days, -1 hours'));
            //   $startDateCK = date_format($startDateTimeCK, 'F j, Y g:i A');
            //   $startFoundCK = True;
            // }
            $dateTime = new DateTime($pulledDate);
            date_add($dateTime, date_interval_create_from_date_string('-1 hours'));
            $date = date_format($dateTime, 'Y-m-d g:i A');
            print "['" .$date ."', ". $hCardKingdomPrice[1] ."],";
          }
          $newdateTime = new DateTime();
          if ($newdateTime == $dateTime)
          {
            $lastUpdateCK = "Not Updated";
          }
          else
          {
            $dateTime = new DateTime($pulledDate);
            $date = date_format($dateTime, 'F jS, Y g:i A');
            $lastUpdateCK = $date;
          }
        }
        $date = date_format($newdateTime, 'Y-m-d g:i A');
        print "['". $date ."', ". $CardKingdomPrice ."]];";
        date_add($newdateTime, date_interval_create_from_date_string('-1 weeks'));
        $date = date_format($newdateTime, 'F j, Y g:i A');
                    //TROLL AND TOAD CODE//
        $sql = "SELECT * FROM `Magic_Cards_Historic_Prices` WHERE CardID = ". $card;
        $historic_result = $conn->Execute($sql);
        if (!$historic_result)
        {
          print $conn->ErrorMsg();
        }
        else
        {
          print "var line2 = [";
          foreach ($historic_result as $id)
          {
            $HID = $id[1];
            // $debug = $id[1];
            $sql = "SELECT * FROM  `Historic_Prices` WHERE HistoricID =". $HID ." AND SourceID = 2";
            $hTrollAndToadPrice_result = $conn->Execute($sql);
            foreach ($hTrollAndToadPrice_result as $hTrollAndToadPrice)
            {
              $pulledDate = $hTrollAndToadPrice[3];
              $dateTime = new DateTime($pulledDate);
              date_add($dateTime, date_interval_create_from_date_string('-1 hours'));
              $date = date_format($dateTime, 'Y-m-d g:i A');
              print "['" .$date ."', ". $hTrollAndToadPrice[1] ."],";
            }
            $newdateTime = new DateTime();
            if ($newdateTime == $dateTime)
            {
              $lastUpdateTAT = "Not Updated";
            }
            else
            {
              $dateTime = new DateTime($pulledDate);
              $date = date_format($dateTime, 'F jS, Y g:i A');
              $lastUpdateTAT = $date;
            }
          }
          $date = date_format($newdateTime, 'Y-m-d g:i A');
          print "['". $date ."', ". $TrollAndToadPrice ."]];";
          date_add($newdateTime, date_interval_create_from_date_string('-1 weeks'));
          $date = date_format($newdateTime, 'F j, Y g:i A');
                ////TOY WIZE CODE////
          $sql = "SELECT * FROM `Magic_Cards_Historic_Prices` WHERE CardID = ". $card;
          $historic_result = $conn->Execute($sql);
          if (!$historic_result)
          {
              print $conn->ErrorMsg();
          }
          else
          {
              print "var line3 = [";
              // $debug = array();
              foreach ($historic_result as $id)
              {
                $HID = $id[1];
                // $debug = $id[1];
                $sql = "SELECT * FROM  `Historic_Prices` WHERE HistoricID =". $HID ." AND SourceID = 3";
                $hToyWizPrice_result = $conn->Execute($sql);
                foreach ($hToyWizPrice_result as $hToyWizPrice)
                {
                  // $debug[] = $hToyWizPrice[0];
                  $pulledDate = $hToyWizPrice[3];
                  $dateTime = new DateTime($pulledDate);
                  date_add($dateTime, date_interval_create_from_date_string('-1 hours'));
                  $date = date_format($dateTime, 'Y-m-d g:i A');
                  print "['" .$date ."', ". $hToyWizPrice[1] ."],";
                }
                $newdateTime = new DateTime();
                if ($newdateTime == $dateTime)
                {
                  $lastUpdateTW = "Not Updated";
                }
                else
                {
                  $dateTime = new DateTime($pulledDate);
                  $date = date_format($dateTime, 'F jS, Y g:i A');
                  $lastUpdateTW = $date;
                }
              }
              $date = date_format($newdateTime, 'Y-m-d g:i A');
              print "['". $date ."', ". $ToyWizPrice ."]];";
              date_add($newdateTime, date_interval_create_from_date_string('-1 weeks'));
              $date = date_format($newdateTime, 'F j, Y g:i A');
                  ////AbuGames Code////
                  $sql = "SELECT * FROM `Magic_Cards_Historic_Prices` WHERE CardID = ". $card;
                  $historic_result = $conn->Execute($sql);
                  if (!$historic_result)
                  {
                      print $conn->ErrorMsg();
                  }
                  else
                  {
                      print "var line4 = [";
                      foreach ($historic_result as $id)
                      {
                        $HID = $id[1];
                        // $debug = $id[1];
                        $sql = "SELECT * FROM  `Historic_Prices` WHERE HistoricID =". $HID ." AND SourceID = 4";
                        $hAbuGamesPrice_result = $conn->Execute($sql);
                        foreach ($hAbuGamesPrice_result as $hAbuGamesPrice)
                        {
                          $pulledDate = $hAbuGamesPrice[3];
                          $dateTime = new DateTime($pulledDate);
                          date_add($dateTime, date_interval_create_from_date_string('-1 hours'));
                          $date = date_format($dateTime, 'Y-m-d g:i A');
                          print "['" .$date ."', ". $hAbuGamesPrice[1] ."],";
                        }
                        $newdateTime = new DateTime();
                        if ($newdateTime == $dateTime)
                        {
                          $lastUpdateABU = "Not Updated";
                        }
                        else
                        {
                          $dateTime = new DateTime($pulledDate);
                          $date = date_format($dateTime, 'F jS, Y g:i A');
                          $lastUpdateABU = $date;
                        }
                      }
                      $date = date_format($newdateTime, 'Y-m-d g:i A');
                      print "['". $date ."', ". $AbuGamesPrice ."]];";
                      date_add($newdateTime, date_interval_create_from_date_string('-1 weeks'));
                      $date = date_format($newdateTime, 'F j, Y g:i A');
                    }
                  }
                }
              }
              print "$.jqplot('chartCKdiv', [line], {
                title:'Card Kingdom Price Projections',
                axesDefaults:
                {
                  tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                  tickOptions:
                    {
                      angle: -30
                    }
                },
                axes:
                  {
                    xaxis:
                      {
                        label: 'Date Updated',
                        renderer:$.jqplot.DateAxisRenderer,
                        min:'". $date ."',
                        tickInterval:'12 hours',
                        tickOptions:{labelPosition:'middle',formatString:'%b %#d, %#I %p'},
                      },
                      yaxis:
                            {
                               label: 'Prices (USD)',
                               min: 0,
                               tickOptions:{labelPosition:'bottom',autoscale:true,formatString: '$%#.2f'}
                      }
                    },
                   highlighter:
                     {
                        show: true,
                        sizeAdjust: 7.5,
                        tooltipAxes: 'y,x'
                     },
                   cursor:
                     {
                       show: false
                     },
                   series:[{lineWidth:4, markerOptions:{style:'square'}}]
                    });
                    $.jqplot('chartTATdiv', [line2], {
                              title:'Troll And Toad Price Projections',
                              axesDefaults:
                              {
                                tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                                tickOptions:
                                  {
                                    angle: -30
                                  }
                              },
                              axes:
                                {
                                  xaxis:
                                    {
                                      label: 'Date Updated',
                                      renderer:$.jqplot.DateAxisRenderer,
                                      min:'". $date ."',
                                      tickInterval:'12 hours',
                                      tickOptions:{labelPosition:'middle',formatString:'%b %#d, %#I %p'},
                                    },
                                    yaxis:
                                          {
                                             label: 'Prices (USD)',
                                             min: 0,
                                             tickOptions:{labelPosition:'bottom',autoscale:true,formatString: '$%#.2f'}
                                    }
                                  },
                                 highlighter:
                                   {
                                      show: true,
                                      sizeAdjust: 7.5,
                                      tooltipAxes: 'y,x'
                                   },
                                 cursor:
                                   {
                                     show: false
                                   },
                                 series:[{lineWidth:4, markerOptions:{style:'square'}}]
                                  });
                                  $.jqplot('chartTWdiv', [line3], {
                                            title:'ToyWiz Price Projections',
                                            axesDefaults:
                                            {
                                              tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                                              tickOptions:
                                                {
                                                  angle: -30
                                                }
                                            },
                                            axes:
                                              {
                                                xaxis:
                                                  {
                                                    label: 'Date Updated',
                                                    renderer:$.jqplot.DateAxisRenderer,
                                                    min:'". $date ."',
                                                    tickInterval:'12 hours',
                                                    tickOptions:{labelPosition:'middle',formatString:'%b %#d, %#I %p'},
                                                  },
                                                  yaxis:
                                                        {
                                                           label: 'Prices (USD)',
                                                           min: 0,
                                                           tickOptions:{labelPosition:'bottom',autoscale:true,formatString: '$%#.2f'}
                                                  }
                                                },
                                               highlighter:
                                                 {
                                                    show: true,
                                                    sizeAdjust: 7.5,
                                                    tooltipAxes: 'y,x'
                                                 },
                                               cursor:
                                                 {
                                                   show: false
                                                 },
                                               series:[{lineWidth:4, markerOptions:{style:'square'}}]
                                                });
                                                $.jqplot('chartTWdiv', [line3], {
                                                                        title:'ToyWiz Price Projections',
                                                                        axesDefaults:
                                                                        {
                                                                          tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                                                                          tickOptions:
                                                                            {
                                                                              angle: -30
                                                                            }
                                                                        },
                                                                        axes:
                                                                          {
                                                                            xaxis:
                                                                              {
                                                                                label: 'Date Updated',
                                                                                renderer:$.jqplot.DateAxisRenderer,
                                                                                min:'". $date ."',
                                                                                tickInterval:'12 hours',
                                                                                tickOptions:{labelPosition:'middle',formatString:'%b %#d, %#I %p'},
                                                                              },
                                                                              yaxis:
                                                                                    {
                                                                                       label: 'Prices (USD)',
                                                                                       min: 0,
                                                                                       tickOptions:{labelPosition:'bottom',autoscale:true,formatString: '$%#.2f'}
                                                                              }
                                                                            },
                                                                           highlighter:
                                                                             {
                                                                                show: true,
                                                                                sizeAdjust: 7.5,
                                                                                tooltipAxes: 'y,x'
                                                                             },
                                                                           cursor:
                                                                             {
                                                                               show: false
                                                                             },
                                                                           series:[{lineWidth:4, markerOptions:{style:'square'}}]
                                                                            });
                                                                            $.jqplot('chartABUdiv', [line4], {
                                                                                      title:'AbuGames Price Projections',
                                                                                      axesDefaults:
                                                                                      {
                                                                                        tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                                                                                        tickOptions:
                                                                                          {
                                                                                            angle: -30
                                                                                          }
                                                                                      },
                                                                                      axes:
                                                                                        {
                                                                                          xaxis:
                                                                                            {
                                                                                              label: 'Date Updated',
                                                                                              renderer:$.jqplot.DateAxisRenderer,
                                                                                              min:'". $date ."',
                                                                                              tickInterval:'12 hours',
                                                                                              tickOptions:{labelPosition:'middle',formatString:'%b %#d, %#I %p'},
                                                                                            },
                                                                                            yaxis:
                                                                                                  {
                                                                                                     label: 'Prices (USD)',
                                                                                                     min: 0,
                                                                                                     tickOptions:{labelPosition:'bottom',autoscale:true,formatString: '$%#.2f'}
                                                                                            }
                                                                                          },
                                                                                         highlighter:
                                                                                           {
                                                                                              show: true,
                                                                                              sizeAdjust: 7.5,
                                                                                              tooltipAxes: 'y,x'
                                                                                           },
                                                                                         cursor:
                                                                                           {
                                                                                             show: false
                                                                                           },
                                                                                         series:[{lineWidth:4, markerOptions:{style:'square'}}]
                                                                                          });
                                                                          });";

              print '</script>';
              print '<div style = "float: left;></div>';
              print '<div style="float: left; width: 45%; height: 50%; padding-left:5em">'.
                    '<table border="1" cellpadding="4">'.
                    '<tr>'.
                    '<td bgcolor="#CCCCCC"><strong>Card Kingdom: </strong></td>'.
                    '<td>$'. $CardKingdomPrice .'</td>'.
                    '<td>Last Updated: '. $lastUpdateCK .'</td>'.
                    '</tr>'.
                    '<tr>'.
                    '<td bgcolor="#CCCCCC"><strong>Troll and Toad: </strong></td>'.
                    '<td>$'. $TrollAndToadPrice .'</td>'.
                    '<td>Last Updated: '. $lastUpdateTAT .'</td>'.
                    '</tr>'.
                    '<tr>'.
                    '<td bgcolor="#CCCCCC"><strong>Toy Wiz: </strong></td>'.
                    '<td>$'. $ToyWizPrice .'</td>'.
                    '<td>Last Updated: '. $lastUpdateTW .'</td>'.
                    '</tr>'.
                    '<tr>'.
                    '<td bgcolor="#CCCCCC"><strong>Abu Games: </strong></td>'.
                    '<td>$'. $AbuGamesPrice .'</td>'.
                    '<td>Last Updated: '. $lastUpdateABU .' </td>'.
                    '</tr>'.
                    '</table></div>';
              print '<div><br><br><br><br><br><br><br><br><br><br><br><br></div>';
              print '<div id="chartCKdiv" style="width: 90%"></div><br><br>';
              print '<div id="chartTATdiv" style="width: 90%"></div><br><br>';
              print '<div id="chartTWdiv" style="width: 90%"></div><br><br>';
              print '<div id="chartABUdiv" style="width: 90%"></div><br><br>';
        }
    }
}
print '</div>';
echo "<title>". $cardName ."</title>";
getFooter();
?>
