<?php $base = strtok($_SERVER['REQUEST_URI'], '?')?>
<nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <?php if ($paginator->previous): ?>
          <a class="page-link" href="<?=$base;?>?page=<?=$paginator->previous?>">
            Prev.
          </a>
        <?php else: ?>
          <span class="page-link text-muted font-weight-bold">Prev.</span>
        <?php endif;?>
      </li>
      <?php if ($paginator->next): ?>
        <li class="page-item">
          <a class="page-link" href="<?=$base;?>?page=<?=$paginator->next?>">
            Next
          </a>
        <?php else: ?>
          <span class="page-link text-muted font-weight-bold">Next</span>
        <?php endif;?>
        </li>
    </ul>
  </nav>