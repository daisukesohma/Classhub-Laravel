<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Chat
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $messages
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $initiator_id
 * @property int $participant_id
 * @property int $initiator_unread_count
 * @property int $participant_unread_count
 * @property string $last_message_text
 * @property int $last_message_by
 * @property string $last_message_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereIniatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereInitiatorUnreadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereLastMessageAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereLastMessageBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereLastMessageText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereParticipantUnreadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereInitiatorId($value)
 * @property int|null $lesson_id
 * @property-read mixed $chat_with
 * @property-read mixed $unread_count
 * @property-read \App\Lesson|null $lesson
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereLessonId($value)
 */
class Chat extends Model
{
    protected $fillable = [
        'lesson_id', 'initiator_id', 'participant_id', 'initiator_unread_count', 'participant_unread_count',
        'last_message_text', 'last_message_by', 'last_message_at'
    ];

    protected $with = ['messages'];

    //public $appends = ['unread_count', 'chat_with'];

    public static function chatExist($senderId, $receiverId)
    {
        return Chat::where([
            ['initiator_id', '=', $senderId],
            ['participant_id', '=', $receiverId]
        ])->orWhere([
            ['initiator_id', '=', $receiverId],
            ['participant_id', '=', $senderId]
        ])->first();
    }

    public static function lessonChatExist($senderId, $receiverId, $lessonId)
    {
        return Chat::where([
            ['lesson_id', '=', $lessonId],
            ['initiator_id', '=', $senderId],
            ['participant_id', '=', $receiverId]
        ])->orWhere([
            ['lesson_id', '=', $lessonId],
            ['initiator_id', '=', $receiverId],
            ['participant_id', '=', $senderId]
        ])->first();
    }

    public function getUnreadCountAttribute()
    {
        $unreadCount = $this->initiator_id == Auth::user()->id ? $this->initiator_unread_count :
            $this->participant_unread_count;

        return $unreadCount;
    }

    public function getChatWithAttribute()
    {
        $withId = $this->initiator_id == Auth::user()->id ? $this->participant_id :
            $this->initiator_id;

        try {
            return User::withTrashed()->findOrFail($withId);
        } catch (\Exception $e) {
            //return User::whereEmail('anonymous@classhub.ie')->first();
        }
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

}
