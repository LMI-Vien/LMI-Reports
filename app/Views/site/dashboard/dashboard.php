
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
  background: linear-gradient(to bottom right, #79311d, #fffde7);
}

.announcement-title {
  font-weight: 600;
  color: #333;
}

.announcement-desc {
  color: #555;
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
    <div class="card-header text-dark rounded-top" style="background-color: #301311; color: #fff !important;">
      <h4 class="mb-0">📢 Announcements</h4>
    </div>
    <div class="card-body">

      <?php if (!empty($announcements)): ?>
        <?php foreach ($announcements as $announcement): ?>
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
        <?php endforeach; ?>
      <?php else: ?>
        <div class="text-center text-muted py-4">
          <span style="font-size: 1.1rem; color: #fff;">No announcements at the moment.</span>
        </div>
      <?php endif; ?>

    </div>
  </div>

</div>

