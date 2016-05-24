<?php
/**
 * Created by Adam Jakab.
 * Date: 24/05/16
 * Time: 10.50
 */

/**
 * Batch processing callback; Generate aliases for nodes.
 */
function mekit_node_pathauto_bulk_update_batch_process(&$context) {
  $batch_size = 10;
  $context['sandbox']['count'] = isset($context['sandbox']['count']) ? $context['sandbox']['count'] : 0;

  $query = db_select('node', 'n');
  $query->leftJoin('url_alias', 'ua', "CONCAT('node/', n.nid) = ua.source");
  $query->addField('n', 'nid');
  $query->orderBy('n.nid');
  $query->addTag('pathauto_bulk_update');
  $query->addMetaData('entity', 'node');

  // Get the total amount of items to process.
  if (!isset($context['sandbox']['total'])) {
    $context['sandbox']['total'] = $query->countQuery()->execute()->fetchField();

    // If there are no nodes to update, the stop immediately.
    if (!$context['sandbox']['total']) {
      $context['finished'] = 1;
      return;
    }
  }

  $query->range($context['sandbox']['count'], $batch_size);
  $nids = $query->execute()->fetchCol();

  if(count($nids)) {
    //dsm("PATHAUTO(".$context['sandbox']['count']."/".$context['sandbox']['total'].") ON NIDS: " . json_encode($nids));
    pathauto_node_update_alias_multiple($nids, 'bulkupdate');
    //
    $context['finished'] = 0;
    $context['sandbox']['count'] += count($nids);
    $context['message'] = t('Updated alias for nodes @nids.', array('@nids' => json_encode($nids)));
  } else {
    $context['finished'] = 1;
  }
}
