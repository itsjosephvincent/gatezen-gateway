<?php

namespace App\Jobs;

use App\Models\Segment;
use App\Models\SegmentCondition;
use App\Models\SegmentUser;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SegmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $segments = Segment::where('is_active', true)->get();
        foreach ($segments as $segment) {
            $conditions = SegmentCondition::where('segment_id', $segment->id)->get();
            foreach ($conditions as $condition) {
                if ($condition->model_type === 'Ticker') {
                    $tickers = User::join('wallets', 'users.id', '=', 'wallets.holdable_id')
                        ->join('tickers', 'wallets.belongable_id', '=', 'tickers.id')
                        ->select('users.*')
                        ->where('tickers.'.$condition->field, $condition->operator, $condition->value)
                        ->get();

                    $this->save($tickers, $segment->id);
                } elseif ($condition->model_type === 'Project') {
                    $projects = User::join('wallets', 'users.id', '=', 'wallets.holdable_id')
                        ->join('tickers', 'wallets.belongable_id', '=', 'tickers.id')
                        ->join('projects', 'tickers.project_id', '=', 'projects.id')
                        ->select('users.*')
                        ->where('projects.'.$condition->field, $condition->operator, $condition->value)
                        ->get();

                    $this->save($projects, $segment->id);
                } elseif ($condition->model_type === 'Tags') {
                    $tags = User::withAnyTags([$condition->value])
                        ->get();

                    $this->save($tags, $segment->id);
                } else {
                    $languages = User::join('languages', 'users.language_id', '=', 'languages.id')
                        ->select('users.*')
                        ->where('languages.'.$condition->field, $condition->operator, $condition->value)
                        ->get();

                    $this->save($languages, $segment->id);
                }
            }
        }
    }

    public function save($results, $segmentId): void
    {
        foreach ($results as $result) {
            $segment_user = SegmentUser::where('segment_id', $segmentId)
                ->where('user_id', $result->id)
                ->first();

            if (! $segment_user) {
                $new_segment_user = new SegmentUser();
                $new_segment_user->segment_id = $segmentId;
                $new_segment_user->user_id = $result->id;
                $new_segment_user->save();
            }
        }
    }
}
