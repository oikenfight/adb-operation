<?php
declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class UploadScreenShot
 * @package App\Events
 */
final class UploadScreenShot implements ShouldBroadcast
{
    use SerializesModels;

    const CHANNEL_NAME = 'upload.screen.shot';

    const EVENT_NAME = 'upload.screen.shot.event';

    /**
     * @var string
     */
    public $filename;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return self::EVENT_NAME;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel(self::CHANNEL_NAME);
    }
}
