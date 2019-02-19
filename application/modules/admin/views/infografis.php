
    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
   
    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

    <script>
    var simplemaps_countrymap_mapdata={
      main_settings: {
       //General settings
        width: "responsive", //'700' or 'responsive'
        background_color: "#FFFFFF",
        background_transparent: "yes",
        border_color: "#ffffff",
        
        //State defaults
        state_description: "State description",
        state_color: "#88A4BC",
        state_hover_color: "#3B729F",
        state_url: "",
        border_size: "0.5",
        all_states_inactive: "no",
        all_states_zoomable: "yes",
        
        //Location defaults
        location_description: "Location description",
        location_url: "",
        location_color: "#FF0067",
        location_opacity: 0.8,
        location_hover_opacity: 1,
        location_size: 25,
        location_type: "circle",
        location_image_source: "frog.png",
        location_border_color: "#FFFFFF",
        location_border: 2,
        location_hover_border: 2.5,
        all_locations_inactive: "no",
        all_locations_hidden: "no",
        
        //Label defaults
        label_color: "#d5ddec",
        label_hover_color: "#d5ddec",
        label_size: 22,
        label_font: "Arial",
        hide_labels: "no",
        hide_eastern_labels: "no",
       
        //Zoom settings
        zoom: "yes",
        manual_zoom: "no",
        back_image: "no",
        initial_back: "no",
        initial_zoom: "-1",
        initial_zoom_solo: "no",
        region_opacity: 1,
        region_hover_opacity: 0.6,
        zoom_out_incrementally: "yes",
        zoom_percentage: 0.99,
        zoom_time: 0.5,
        
        //Popup settings
        popup_color: "white",
        popup_opacity: 0.9,
        popup_shadow: 1,
        popup_corners: 5,
        popup_font: "12px/1.5 Verdana, Arial, Helvetica, sans-serif",
        popup_nocss: "no",
        
        //Advanced settings
        div: "map",
        auto_load: "yes",
        url_new_tab: "yes",
        images_directory: "default",
        fade_time: 0.1,
        link_text: "View Website",
        popups: "detect",
        state_image_url: "",
        state_image_position: "",
        location_image_url: "",
        border_hover_color: "#ffffff",
        border_hover_size: "1.5"
      },
      state_specific: {
        <?php foreach($by_provinsi as $b):?>
        <?=$b->kode?>: {
          <?php if($b->jumlah > 600 ):?>
          color: "#509b22",
          <?elseif($b->jumlah > 300 ):?>
          color: "#66c52b",
          <?elseif($b->jumlah > 90 ):?>
          color: "#81d84b",
          <?elseif($b->jumlah > 30 ):?>
          color: "#9ee175",
          <?elseif($b->jumlah > 0 ):?>
          color: "#bcea9f",
          <?else:?>
          
          <?php endif?>
          name: "<?=$b->provinsi?>",
          description: "<?=$b->jumlah?> Lembaga"
        },
        <?php endforeach?>
      },
      locations: {
        "0": {
          lat: "-7.250445",
          lng: "112.768845",
          name: "Ummifoundation",
          color: "#ffa925",
          description: "Kantor Pusat Ummifoundation",
          url: "https://ummifoundation.org",
          size: "25",
          image_url: "https://i.ibb.co/WVBkbzM/ummi-location-tag-1.png",
          type: "image"
        }
      },
      labels: {
        "0": {
          name: "Ummi Foundation",
          x: "-7.250445",
          y: "112.768845"
        }
      },
      regions: {},
      data: {
        data: {
          <?php foreach($by_provinsi as $b):?>
          <?=$b->kode?>: "<?= $b->jumlah?>",
          <?php endforeach?>
        }
      }
    };    
        
    </script>    
    
    <script src="<?= base_url() ?>assets/maps/countrymap.js" ></script>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Lembaga', { role: 'style' }],
          <?php $color = array('#5bc8fa','#ffcc01','#ff9500','#ff2c55','#007aff','#4cd965','#ff3a30','#8e8e93');?>
          <?php $i=0?>
          <?php foreach($perkembangan_pengguna as $d):?>
          ['<?=$d->ColumnB ?>', <?=$d->ColumnA?>,'<?=$color[$i]?>'],
          <?php $i++?>
          <?php endforeach?>
        ]);
        

          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1,
                           { calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation" },
                           2]);
    
          var options = {
            isStacked: true,
            width: 400,
            height: 250,
            bar: {groupWidth: "60%"},
            legend: { position: "none" },
            
          };

        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
      }
    </script>
    
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jenis', 'Jumlah'],
          <?php foreach($formal as $f):?>
          ['<?=$f->jenis_lembaga?>',<?= $f->jumlah?>],
          <?php endforeach?>
        ]);

        var options = {
          pieHole: 0.4,
          
        };

        var chart = new google.visualization.PieChart(document.getElementById('formal'));
        chart.draw(data, options);
      }
    </script>
    
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jenis', 'Jumlah'],
          <?php foreach($informal as $f):?>
          ['<?=$f->jenis_lembaga?>',<?= $f->jumlah?>],
          <?php endforeach?>
        ]);

        var options = {
          pieHole: 0.4,
          
        };

        var chart = new google.visualization.PieChart(document.getElementById('informal'));
        chart.draw(data, options);
      }
    </script>
    
    <style>
    .cover-trial {
        z-index: 2;
        position: absolute;
        top: 990px;
        right: 0;
        width: 299px;
        height: 50px;
        background: #ffffff;;
    }
        
    </style>
    
    <style type="text/css">
    .legend{color: black; width: 300px; font-family: arial; font-size: 14px;}    
    .legend_color {display: table; width: 100%; background: white; list-style: none; margin: 0px; padding: 0px; }
    .legend_color li{width: 20%;  height: 20px; display: table-cell;}
    .legend_label {display: table; width: 100%;  padding: 0px; padding-left: 10%; padding-right: 10%; list-style: none; margin: 0px; box-sizing: border-box;}
    .legend_label li{width: 25%;  height: 20px; display: table-cell; text-align: center;}
    </style>
    
    
  </head>
  <body class="A4">
      <section class="sheet padding-10mm">
          <div class="cover-trial"></div>
          <table width="100%">
              <tr>
                  <td width="50%">
                      <div class="text-center font-bold">  
                      <img class="pb-4" src="https://ummifoundation.org/po-includes/images/logo_ummi.png" width="230">
                    <p>INFOGRAFIS PERKEMBANGAN PENGGUNA</p>
                   <p style="font-size:45px" class="font-bold text-green">METODE UMMI</p> 
                   <p> DARI TAHUN 2011   HINGGA 2018</p>
                  </div>
                   
                 </td>
                 

                  <td>
                    <div id="columnchart_values" style="width: 400px; height: 250px;"></div>
                  </td>
              </tr>
              <tr>
                 <td class="text-center font-bold" colspan="2">
                   <p>PENGGUNA METODE UMMI BERDASARKAN JENJANG</p>
                   <p>PENDIDIKAN FORMAL /INFORMAL</p>
                 </td>
              </tr>
              <tr>
                  <td>
                    <div id="formal" style="width: 350px; height: 200px;"></div>
                  </td>
                  <td>
                    <div id="informal" style="width: 350px; height: 200px;"></div>
                  </td>
              </tr>
              <tr>
                  <td class="font-bold text-center" style="position: relative; top: -30px;">Formal</td>
                  <td class="font-bold text-center" style="position: relative; top: -30px;">Informal</td>
              </tr>
          </table>
          <br>
         
          <div class="flex font-bold">
              <div class="flex-1 text-center">
                  <p class="text-4xl font-bold text-green"><?= $provinsi ?></p>
                  <p class="text-sm text-grey">Provinsi</p>
              </div>
              <div class="flex-1 text-center">
                  <p class="text-4xl font-bold text-green"><?= $ummidaerah ?></p>
                  <p class="text-sm text-grey">Ummi Daerah</p>
              </div>
              <div class="flex-1 text-center">
                  <p class="text-4xl font-bold text-green"><?= number_format($lembaga) ?></p>
                  <p class="text-sm text-grey">Lembaga</p>
              </div>
              <div class="flex-1 text-center">
                  <p class="text-4xl font-bold text-green"><?= $trainer ?></p>
                  <p class="text-sm text-grey">Trainer</p>
              </div>
          </div>
          <div class="flex font-bold">
              <div class="flex-1 text-center">
                  <p class="text-4xl font-bold text-green"><?= number_format($guru) ?></p>
                  <p class="text-sm text-grey">Guru Quran</p>
              </div>
              <div class="flex-1 text-center">
                  <p class="text-4xl font-bold text-green"><?= number_format($santri) ?></p>
                  <p class="text-sm text-grey">Santri</p>
              </div>
          </div>
          <div class="flex">
              
            <div class="flex-1" id="map" style="width:800px"></div>
              
          </div>
          
            <div class="legend">
            <ul class="legend_label">
            <li>30</li><li>90</li><li>300</li><li>600</li>
            </ul>
            <ul class="legend_color">
            <li style="background-color: #bcea9f"></li><li style="background-color: #9ee175"></li><li style="background-color: #81d84b"></li><li style="background-color: #66c52b"></li><li style="background-color: #509b22"></li>
            </ul>
            </div>
          
          
        
      </section>

    <script>
        // Send message to the top window (parent) at 500ms interval
    setInterval(function() {
        // first parameter is the message to be passed
        // second paramter is the domain of the parent 
        // in this case "*" has been used for demo sake (denoting no preference)
        // in production always pass the target domain for which the message is intended 
        window.top.postMessage(document.body.scrollHeight, "*");
    }, 500); 
    
    </script>
