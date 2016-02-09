<?php

namespace Drupal\relaxed\Plugin\Replicator;

use Doctrine\CouchDB\CouchDBClient;
use Drupal\relaxed\Plugin\ReplicatorBase;
use Psr\Http\Message\UriInterface;
use Relaxed\Replicator\Replication;
use Relaxed\Replicator\ReplicationTask;

/**
 * @Replicator(
 *   id = "couchdb",
 *   label = "Relaxed Replicator"
 * )
 */
class CouchDbReplicator extends ReplicatorBase {
  /**
   * @inheritDoc
   */
  public function setSource(UriInterface $source) {
    // Create the source client.
    $this->source = CouchDBClient::create([
      'url' => (string) $source,
      'timeout' => 10
    ]);

    return $this;
  }

  /**
   * @inheritDoc
   */
  public function setTarget(UriInterface $target) {
    // Create the target client.
    $this->target = CouchDBClient::create([
      'url' => (string) $target,
      'timeout' => 10
    ]);

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function push() {
    try {
      // Create the replication task.
      $task = new ReplicationTask();
      // Create the replication.
      $replication = new Replication($this->source, $this->target, $task);
      // Generate and set a replication ID.
      $replication->task->setRepId($replication->generateReplicationId());
      // Filter by document IDs if set.
      if (!empty($this->docIds)) {
        $replication->task->setDocIds($this->docIds);
      }
      // Start the replication.
      $replicationResult = $replication->start();
    }
    catch (\Exception $e) {
      \Drupal::logger('Relaxed')->info($e->getMessage() . ': ' . $e->getTraceAsString());
      return ['error' => $e->getMessage()];
    }
    // Return the response.
    return $replicationResult;
  }
}