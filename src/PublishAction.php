<?php

namespace Den1n\NovaPages;

use App\AccountData;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PublishAction extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the displayable name of the action.
     */
    public function name(): string
    {
        return __('Publish pages');
    }

    /**
     * Perform the action on the given models.
     */
    public function handle(ActionFields $fields, Collection $models): array
    {
        foreach ($models as $model) {
            $model->published = true;
            $model->save();
        }
        return Action::message(__('Pages are published!'));
    }
}
