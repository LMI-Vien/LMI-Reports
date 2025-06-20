
<style>
.card:empty {
  display: none;
  margin: 0 !important;
  padding: 0 !important;
}
.card-medium {
  background-color: #fff;
  border-radius: 0.5rem;
}

.card-body {
  /* background: linear-gradient(to bottom right, #79311d, #fffde7); */
  background: linear-gradient(to bottom right, #f7e9dc, #d6bfa7);
}

.announcement-title {
  font-weight: 600;
  color: #333;
}

.announcement-desc {
  color: #555;
}

.modal-content {
    border: none;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); /* Stronger shadow for depth */
    background-color: #fff;
}

/* Optional: Add a border to match the announcement panel’s tones */
.modal-header {
    background-color: #2c2c2c; /* Darker to match background */
    border-bottom: 1px solid #444;
}

.modal-body {
    background-color: #ffffff;
    color: #333;
}

.modal-footer {
    background-color: #f7f7f7;
    border-top: 1px solid #ddd;
}

.modal-dialog {
    margin: 1.75rem auto;
    max-width: 700px;
}
.glossy-header {
  background-color: #2c0e0e;
  color: #fff !important;
}

</style>

<div class="content-wrapper p-3" style="display: block;">
    <?php if (isset($breadcrumb)): ?>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent px-0 mb-0">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <?php 
                        $last = end($breadcrumb);
                        foreach ($breadcrumb as $label => $url): 
                            if ($url != ''):
                    ?>
                        <li class="breadcrumb-item">
                            <?= $label ?>
                        </li>
                    <?php else: ?>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= $label ?>
                        </li>
                    <?php 
                            endif;
                        endforeach; 
                    ?>
                </ol>
            </nav>
        </div>
    <?php endif; ?>
  <div class="card shadow-lg mb-4 bg-light border-0">
    <div class="card-header text-white rounded-top glossy-header">
      <div>
        <h4 class="mb-1" style='font-weight: 700; text-transform: uppercase;'>Announcements</h4>
        <small class="d-block text-muted text-white" style="font-family: Spiegel, sans-serif;">Stay up-to-date with the latest news, updates, and important notices.</small>
      </div>
    </div>
    <div class="card-body">

      <?php if (!empty($announcements)): ?>
        <?php foreach ($announcements as $announcement): ?>
          <div class="card mb-3 shadow-sm border-left-warning card-medium bg-white">
            <div class="row g-2 p-3">
              <div class="col-md-12">
                <!-- Title and Badge -->
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <div class="d-flex align-items-center">
                    <div class="announcement-title" style="font-size: 1.1rem; font-weight: 600; margin-right: 10px;">
                      <?= $announcement->title ?>
                    </div>

                    <span 
                      class="badge px-2 py-1" 
                      style="border-radius: 5px; 
                            background-color: <?= isset($announcementTypes[$announcement->description_1]) ? $announcementTypes[$announcement->description_1] : '#6C757D' ?>; 
                            color: white;"
                    >
                      <?= $announcement->description_1 ?>
                    </span>
                  </div>

                  <a href="#" onclick="announcementDetail(<?= $announcement->id ?>)">Learn More...</a>
                </div>

                <!-- Optional extra descriptions -->
                <div class="d-flex justify-content-between mb-2">
                  <?php if (!empty($announcement->description_2)): ?>
                    <div class="announcement-title text-muted" style="font-size: 0.95rem;">
                      <?= $announcement->description_2 ?>
                    </div>
                  <?php endif; ?>

                  <div class="text-muted" style="font-size: 0.85rem;">
                    Active from <strong><?= date('F j, Y', strtotime($announcement->start_date)) ?></strong> 
                    to <strong><?= date('F j, Y', strtotime($announcement->end_date)) ?></strong>
                  </div>
                </div>
                
                <!-- <div class="d-flex mb-2">
                  <?php if (!empty($announcement->description_3)): ?>
                    <div class="announcement-desc text-muted" style="font-size: 0.95rem; text-align: left;">
                      <?= $announcement->description_3 ?>
                    </div>
                  <?php endif; ?>
                </div> -->
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <!-- <?php foreach ($announcements as $announcement): ?>
          <div class="card mb-3 shadow-sm border-left-warning card-medium bg-white">
            <div class="row g-2 p-3">
              <div class="col-md-12">
                <div class="announcement-title" style="font-size: 1.1rem; font-weight: 600;">
                  <?= $announcement->title ?>
                </div>
                <div class="announcement-desc text-muted" style="font-size: 0.95rem;">
                  <?= $announcement->description_1 ?>
                </div>
                <div class="announcement-desc text-muted" style="font-size: 0.95rem;">
                  <?= $announcement->description_2 ?>
                </div>
                <div class="announcement-desc text-muted" style="font-size: 0.95rem;">
                  <?= $announcement->description_3 ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?> -->
      <?php else: ?>
        <div class="text-center text-muted py-4">
          <span style="font-size: 1.1rem; color: #fff;">No announcements at the moment.</span>
        </div>
      <?php endif; ?>

    </div>
  </div>

</div>


<div class="modal" tabindex="-1" id="popup_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h1 class="modal-title">
                  <b></b>
              </h1>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span>&times;</span>
              </button>
          </div>

          <div class="modal-body">
            
          </div>

          <div class="modal-footer">
            
          </div>
      </div>
  </div>
</div>

<script>
  var url = "<?= base_url("cms/global_controller");?>";
  var announcementTypes = <?= json_encode($announcementTypes) ?>;
  
  $(document).ready(function () {
  })

  function formatDate(dateStr) {
    const date = new Date(dateStr);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString(undefined, options);
  }

  function getDetails(data) {
    event.preventDefault();
    let $modal = $('#popup_modal');
    let $header = $modal.find('.modal-header .modal-title b');
    let $body = $modal.find('.modal-body');
    let $footer = $modal.find('.modal-footer');

    let headerhtml = '';
    let bg_color = announcementTypes[data[0].description_1]
    headerhtml+=`
    <div class="d-flex align-items-center">
    <div class="announcement-title" style="font-size: 1.1rem; font-weight: 600; margin-right: 10px; color: #fff !important;">
    ${data[0].title}
    </div>
    <span
    class="badge px-2 py-1" 
    style="border-radius: 5px; 
    font-size: 0.8rem;
    background-color: ${bg_color}; 
    color: white;"
    >
    ${data[0].description_1}
    </span>
    </div>
    `
    $header.html(headerhtml)
    
    let bodyhtml = '';
    bodyhtml+=`
    <div class="announcement-title text-muted" style="font-size: 0.95rem;">
      ${data[0].description_2}
    </div>
    <div class="announcement-desc text-muted mt-3" style="font-size: 0.95rem;">
      ${data[0].description_3}
    </div>
    `
    $body.html(bodyhtml)

    let footerhtml = '';
    let start_date = formatDate(data[0].start_date);
    let end_date = formatDate(data[0].end_date);
    footerhtml = `
      <div class="d-flex justify-content-between w-100 align-items-center">
        <div class="text-muted" style="font-size: 0.85rem;">
          Active from <strong>${start_date}</strong> 
          to <strong>${end_date}</strong>
        </div>
        <button onclick="closeModal()" class="btn caution">Close</button>
      </div>
    `;
    $footer.html(footerhtml);

    $modal.modal('show');
  }

  function closeModal() {
    $('#popup_modal').modal('hide');
  }

  function announcementDetail(id) {
    dynamic_search(
      "'tbl_announcements'", 
      "''", 
      "'id, title, description_1, description_2, description_3, start_date, end_date'", 
      0, 
      0, 
      `'id:EQ=${id}'`,  
      `''`, 
      `''`,
      (res) => {
        getDetails(res)
      }
  )
  }
</script>