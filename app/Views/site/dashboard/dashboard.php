<style>
    .col {
      padding-right: 5px !important;
      padding-left: 5px !important;
    }
    .card {
      position: relative;
      /* width: 190px; */
      /* height: 254px; */
      color: white;
      background-color: #000;
      display: flex;
      flex-direction: column;
      justify-content: end;
      padding: 12px;
      gap: 12px;
      border-radius: 8px;
      cursor: pointer;
    }

    .card::before {
      content: '';
      position: absolute;
      inset: 0;
      left: -5px;
      margin: auto;
      border-radius: 10px;
      background: linear-gradient(-45deg, #e81cff 0%, #40c9ff 100% );
      z-index: -10;
      pointer-events: none;
      transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .card::after {
      content: "";
      z-index: -1;
      position: absolute;
      inset: 0;
      background: linear-gradient(-45deg, #fc00ff 0%, #00dbde 100% );
      transform: translate3d(0, 0, 0) scale(0.95);
      filter: blur(20px);
    }

    .heading {
      font-size: 20px;
      text-transform: capitalize;
      font-weight: 700;
    }

    .card p:not(.heading) {
      font-size: 14px;
    }

    .card p:last-child {
      color: #e81cff;
      font-weight: 600;
    }

    .card:hover::after {
      filter: blur(30px);
    }

    .card:hover::before {
      transform: rotate(-3deg) scaleX(1) scaleY(1);
    }

    table {
      color:white;
    }
    .content {
      padding: 20px;
      margin-top: 20px;
    }
</style>

  <div class="row content">
    <div class="col-md-4 col-sm-6 mb-3">
      <div class="card text-center p-3 shadow"><h1 class="font-weight-bold">
              <h3 class="box-title">
                <div class="box-icon">
                  <i class="fas fa-users"></i>
                </div>
                Total Brand Ambassador
              </h3>
              <p class="box-value" id="ba-count">0</p>

            </h1></div>
    </div>
    <div class="col-md-4 col-sm-6 mb-3">
      <div class="card text-center p-3 shadow"><h1 class="font-weight-bold">
              <h3 class="box-title">
                <div class="box-icon">
                  <i class="fas fa-store"></i>
                </div>
                Total Store
              </h3>
              <p class="box-value" id="store-count">0</p>

            </h1></div>
    </div>
    <div class="col-md-4 col-sm-6 mb-3">
      <div class="card text-center p-3 shadow"><h1 class="font-weight-bold">
              <h3 class="box-title">
                <div class="box-icon">
                  <i class="fas fa-building"></i>
                </div>
                Total Company
              </h3>
              <p class="box-value" id="company-count">0</p>

            </h1></div>
    </div>
    <div class="col-md-4 col-sm-6 mb-3">
      <div class="card text-center p-3 shadow"><h1 class="font-weight-bold">
              <h3 class="box-title">
                <div class="box-icon">
                  <i class="fas fa-users"></i>
                </div>
                Total Team
              </h3>
              <p class="box-value" id="team-count">0</p>

            </h1></div>
    </div>
    <div class="col-md-4 col-sm-6 mb-3">
      <div class="card text-center p-3 shadow"><h1 class="font-weight-bold">
              <h3 class="box-title">
                <div class="box-icon">
                  <i class="fas fa-users"></i>
                </div>
                Total Area
              </h3>
              <p class="box-value" id="area-count">0</p>

            </h1></div>
    </div>
    <div class="col-md-4 col-sm-6 mb-3">
      <div class="card text-center p-3 shadow"><h1 class="font-weight-bold">
              <h3 class="box-title">
                <div class="box-icon">
                  <i class="fas fa-briefcase"></i>
                </div>
                Total Agency
              </h3>
              <p class="box-value" id="agency-count">0</p>

            </h1></div>
    </div>
    <div class="col-md-4 col-sm-6 mb-3">
      <div class="card text-center p-3 shadow"><h1 class="font-weight-bold">
              <h3 class="box-title">
                <div class="box-icon">
                  <i class="fas fa-users"></i>
                </div>
                Total ASC
              </h3>
              <p class="box-value" id="asc-count">0</p>

            </h1></div>
    </div>
  </div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: '<?php echo base_url('dashboard/get-counts'); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#company-count').text(response.company);
                $('#area-count').text(response.area);
                $('#store-count').text(response.store);
                $('#agency-count').text(response.agency);
                $('#team-count').text(response.team);
                $('#ba-count').text(response.ba);
                $('#asc-count').text(response.asc);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching counts:', error);
            }
        });
    });
</script>

