@section('dashboard-content')
{{ Breadcrumbs::render('dashboard') }}
<section class="section">
    <div class="row">
        <div class="col-md-6">
            <div class="col-12">
                <div class="card " data-exclude="xs" id="dashboard-history">
                    <div class="card-header bordered">
                        <div class="header-block">
                            <h3 class="card-title text-primary">Today's Activity</h3>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="col progressBar hidden">
                            <center>
                                <div class="lds-ring">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </center>
                        </div>
                        <div class="row" id="todays_activitiesContainer">


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 stats-col">
                <div class="card stats" data-exclude="xs">
                    <div class="card-header bordered">
                        <div class="header-block">
                            <h4 class="card-title text-primary"> Stats </h4>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="col progressBar hidden">
                            <center>
                                <div class="lds-ring">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </center>
                        </div>
                        <div class="row row-sm stats-container">
                            <div class="col-12 col-sm-6  stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-group"></i>
                                </div>
                                <div class="stat">
                                    <div class="value" id="totalSections"> </div>
                                    <div class="name"> Total Sections </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6  stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="stat">
                                    <div class="value" id="totalStudents"> </div>
                                    <div class="name"> Total students </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6  stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <div class="stat">
                                    <div class="value" id="totalActivities"> </div>
                                    <div class="name"> Total Activities </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <div class="stat">
                                    <div class="value" id="totalSubmits"></div>
                                    <div class="name"> Submitted Activities </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-hdd-o"></i>
                                </div>
                                <div class="stat">
                                    <div class="value" id="totalStorage"> </div>
                                    <div class="name"> Storage Size </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card sales-breakdown" data-exclude="xs,sm,lg">
                    <div class="card-header bordered">
                        <div class="header-block">
                            <h3 class="card-title text-primary"> Storage breakdown </h3>
                        </div>
                    </div>
                    <div class="card-block  stats-container">
                        <div class="col progressBar hidden">
                            <center>
                                <div class="lds-ring">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </center>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="dashboard-storage-breakdown-chart" id="dashboard-storage-breakdown-chart"></div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="stats col-6 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-hdd-o"></i>
                                </div>
                                <div class="stat">
                                    <div class="value" id="totalStorageSizeChart"> </div>
                                    <div class="name"> Storage Size </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6">
                                <table id="sectionStorageInfo">

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-12">
                <div class="card sameheight-item">
                    <div class="card-header bordered">
                        <div class="header-block">
                            <h3 class="card-title text-primary"> Sessions </h3> &nbsp;
                            <em> {{$current_date}} </em>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="col progressBar hidden">
                            <center>
                                <div class="lds-ring">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </center>
                        </div>
                        <div class="col">
                            <div id="sessionsContainer"></div>
                        </div>
                        <div class="col-12">
                            <small>
                                <i class="fa fa-circle green"></i> Active &nbsp;
                                <i class="fa fa-circle"></i> Logged out</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>

<script type="text/javascript">
function updateStats() {
    $.ajax({
        type: 'GET',
        url: '{{route('
        ajax.stats ')}}',
        success: function (response) {
            var data = response;
            $('#sessionsContainer').empty();
            $('#sessionsContainer').append(data.sessions);
            $('#todays_activitiesContainer').empty();
            $('#todays_activitiesContainer').append(data.todays_activities);
            $('#totalSections').text(data.stats.total_sections);
            $('#totalStudents').text(data.stats.total_students);
            $('#totalActivities').text(data.stats.total_activities);
            $('#totalSubmits').text(data.stats.total_submits);
            $('#totalStorage').text(data.stats.total_storage);
            $('#totalStorageSizeChart').text(data.stats.total_storage);
            storageChart(data.section_storage);
            $('.progressBar').fadeOut('200');

        }
    });
}

function storageChart(data) {

    var $dashboardSalesBreakdownChart = $('#dashboard-storage-breakdown-chart');

    if (!$dashboardSalesBreakdownChart.length) {
        return false;
    }
    $('#sectionStorageInfo').empty();
    var items = [];
    for (var a in data) {
        items[a] = {
            label: data[a].path,
            value: data[a].percent
        }
        $('#sectionStorageInfo').append('<tr>\
          <td><small><i class="fa fa-folder-o"></i> ' + data[a].path + ' </small></td>\
          <td><small>' + data[a].size + '</small></td>\
      </tr>');
    }

    function drawSalesChart(items) {

        $dashboardSalesBreakdownChart.empty();

        Morris.Donut({
            element: 'dashboard-storage-breakdown-chart',
            data: items,
            resize: true,
            colors: [
                tinycolor(config.chart.colorPrimary.toString()).lighten(10).toString(),
                tinycolor(config.chart.colorPrimary.toString()).darken(8).toString(),
                config.chart.colorPrimary.toString()
            ],
        });

        var $sameheightContainer = $dashboardSalesBreakdownChart.closest(".sameheight-container");

        setSameHeights($sameheightContainer);
    }

    drawSalesChart(items);




};
window.onload = function () {
    $('.progressBar').fadeIn('200');

    updateStats();
}

setInterval("updateStats()", 10000);

$('#addRuleButton').click(function (event) {
    var ruleName = $('#addRuleTitleInput').val();
    var ruleExtensions = $('#addRuleExtensionsInput').val();
});

</script>
 {{--
<section class="section">
  <div class="row sameheight-container">
    <div class="col-xl-8">
      <div class="card  items" data-exclude="xs,sm,lg">
        <div class="card-header bordered">
          <div class="header-block">
            <h3 class="card-title text-primary"> Items </h3>
            <a href="item-editor.html" class="btn btn-primary btn-sm"> Add new </a>
          </div>
          <div class="header-block pull-right">
            <label class="search">
                            <input class="search-input" placeholder="search...">
                            <i class="fa fa-search search-icon"></i>
                        </label>
            <div class="pagination">
              <a href="" class="btn btn-primary btn-sm">
                                <i class="fa fa-angle-up"></i>
                            </a>
              <a href="" class="btn btn-primary btn-sm">
                                <i class="fa fa-angle-down"></i>
                            </a>
            </div>
          </div>
        </div>
        <ul class="item-list striped">
          <li class="item item-list-header">
            <div class="item-row">
              <div class="item-col item-col-header fixed item-col-img xs"></div>
              <div class="item-col item-col-header item-col-title">
                <div>
                  <span>Name</span>
                </div>
              </div>
              <div class="item-col item-col-header item-col-sales">
                <div>
                  <span>Sales</span>
                </div>
              </div>
              <div class="item-col item-col-header item-col-stats">
                <div class="no-overflow">
                  <span>Stats</span>
                </div>
              </div>
              <div class="item-col item-col-header item-col-date">
                <div>
                  <span>Published</span>
                </div>
              </div>
            </div>
          </li>
          <li class="item">
            <div class="item-row">
              <div class="item-col fixed item-col-img xs">
                <a href="">
                  <div class="item-img xs rounded" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg)"></div>
                </a>
              </div>
              <div class="item-col item-col-title no-overflow">
                <div>
                  <a href="" class="">
                    <h4 class="item-title no-wrap"> 12 Myths Uncovered About IT &amp; Software </h4>
                  </a>
                </div>
              </div>
              <div class="item-col item-col-sales">
                <div class="item-heading">Sales</div>
                <div> 4958 </div>
              </div>
              <div class="item-col item-col-stats">
                <div class="item-heading">Stats</div>
                <div class="no-overflow">
                  <div class="item-stats sparkline" data-type="bar"></div>
                </div>
              </div>
              <div class="item-col item-col-date">
                <div class="item-heading">Published</div>
                <div> 21 SEP 10:45 </div>
              </div>
            </div>
          </li>
          <li class="item">
            <div class="item-row">
              <div class="item-col fixed item-col-img xs">
                <a href="">
                  <div class="item-img xs rounded" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/_everaldo/128.jpg)"></div>
                </a>
              </div>
              <div class="item-col item-col-title no-overflow">
                <div>
                  <a href="" class="">
                    <h4 class="item-title no-wrap"> 50% of things doesn&#x27;t really belongs to you </h4>
                  </a>
                </div>
              </div>
              <div class="item-col item-col-sales">
                <div class="item-heading">Sales</div>
                <div> 192 </div>
              </div>
              <div class="item-col item-col-stats">
                <div class="item-heading">Stats</div>
                <div class="no-overflow">
                  <div class="item-stats sparkline" data-type="bar"></div>
                </div>
              </div>
              <div class="item-col item-col-date">
                <div class="item-heading">Published</div>
                <div> 21 SEP 10:45 </div>
              </div>
            </div>
          </li>
          <li class="item">
            <div class="item-row">
              <div class="item-col fixed item-col-img xs">
                <a href="">
                  <div class="item-img xs rounded" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/eduardo_olv/128.jpg)"></div>
                </a>
              </div>
              <div class="item-col item-col-title no-overflow">
                <div>
                  <a href="" class="">
                    <h4 class="item-title no-wrap"> Vestibulum tincidunt amet laoreet mauris sit sem aliquam cras maecenas vel aliquam. </h4>
                  </a>
                </div>
              </div>
              <div class="item-col item-col-sales">
                <div class="item-heading">Sales</div>
                <div> 2143 </div>
              </div>
              <div class="item-col item-col-stats">
                <div class="item-heading">Stats</div>
                <div class="no-overflow">
                  <div class="item-stats sparkline" data-type="bar"></div>
                </div>
              </div>
              <div class="item-col item-col-date">
                <div class="item-heading">Published</div>
                <div> 21 SEP 10:45 </div>
              </div>
            </div>
          </li>
          <li class="item">
            <div class="item-row">
              <div class="item-col fixed item-col-img xs">
                <a href="">
                  <div class="item-img xs rounded" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/why_this/128.jpg)"></div>
                </a>
              </div>
              <div class="item-col item-col-title no-overflow">
                <div>
                  <a href="" class="">
                    <h4 class="item-title no-wrap"> 10 tips of Object Oriented Design </h4>
                  </a>
                </div>
              </div>
              <div class="item-col item-col-sales">
                <div class="item-heading">Sales</div>
                <div> 124 </div>
              </div>
              <div class="item-col item-col-stats">
                <div class="item-heading">Stats</div>
                <div class="no-overflow">
                  <div class="item-stats sparkline" data-type="bar"></div>
                </div>
              </div>
              <div class="item-col item-col-date">
                <div class="item-heading">Published</div>
                <div> 21 SEP 10:45 </div>
              </div>
            </div>
          </li>
          <li class="item">
            <div class="item-row">
              <div class="item-col fixed item-col-img xs">
                <a href="">
                  <div class="item-img xs rounded" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/w7download/128.jpg)"></div>
                </a>
              </div>
              <div class="item-col item-col-title no-overflow">
                <div>
                  <a href="" class="">
                    <h4 class="item-title no-wrap"> Sometimes friend tells it is cold </h4>
                  </a>
                </div>
              </div>
              <div class="item-col item-col-sales">
                <div class="item-heading">Sales</div>
                <div> 10214 </div>
              </div>
              <div class="item-col item-col-stats">
                <div class="item-heading">Stats</div>
                <div class="no-overflow">
                  <div class="item-stats sparkline" data-type="bar"></div>
                </div>
              </div>
              <div class="item-col item-col-date">
                <div class="item-heading">Published</div>
                <div> 21 SEP 10:45 </div>
              </div>
            </div>
          </li>
          <li class="item">
            <div class="item-row">
              <div class="item-col fixed item-col-img xs">
                <a href="">
                  <div class="item-img xs rounded" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/pankogut/128.jpg)"></div>
                </a>
              </div>
              <div class="item-col item-col-title no-overflow">
                <div>
                  <a href="" class="">
                    <h4 class="item-title no-wrap"> New ways of conceptual thinking </h4>
                  </a>
                </div>
              </div>
              <div class="item-col item-col-sales">
                <div class="item-heading">Sales</div>
                <div> 3217 </div>
              </div>
              <div class="item-col item-col-stats">
                <div class="item-heading">Stats</div>
                <div class="no-overflow">
                  <div class="item-stats sparkline" data-type="bar"></div>
                </div>
              </div>
              <div class="item-col item-col-date">
                <div class="item-heading">Published</div>
                <div> 21 SEP 10:45 </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>

  </div>
</section>
<section class="section map-tasks">
  <div class="row sameheight-container">

    <div class="col-md-4">
      <div class="card tasks " data-exclude="xs,sm">
        <div class="card-header bordered">
          <div class="header-block">
            <h3 class="card-title text-primary"> Tasks </h3>
          </div>
          <div class="header-block pull-right">
            <a href="" class="btn btn-primary btn-sm rounded pull-right"> Add new </a>
          </div>
        </div>
        <div class="card-block">
          <div class="tasks-block">
            <ul class="item-list">
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox" checked="checked">
                                            <span>Meeting with embassador</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox" checked="checked">
                                            <span>Confession</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox">
                                            <span>Time to start building an ark</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox">
                                            <span>Beer time with dudes</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox" checked="checked">
                                            <span>Meeting new girls</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox">
                                            <span>Remember damned home address</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox">
                                            <span>Get home before you got sleep</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox" checked="checked">
                                            <span>Meeting with embassador</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox" checked="checked">
                                            <span>Confession</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox">
                                            <span>Time to start building an ark</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox">
                                            <span>Beer time with dudes</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox" checked="checked">
                                            <span>Meeting new girls</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="item">
                <div class="item-row">
                  <div class="item-col item-col-title">
                    <label>
                                            <input class="checkbox" type="checkbox">
                                            <span>Remember damned home address</span>
                                        </label>
                  </div>
                  <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                      <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                                            </a>
                      <div class="item-actions-block">
                        <ul class="item-actions-list">
                          <li>
                            <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="check" href="#">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                          </li>
                          <li>
                            <a class="edit" href="item-editor.html">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> --}}


@endsection
