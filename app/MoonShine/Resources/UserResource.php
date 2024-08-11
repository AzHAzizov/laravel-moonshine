<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Events\UserStatusChanged;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\MoonShine\Pages\User\UserIndexPage;
use App\MoonShine\Pages\User\UserFormPage;
use App\MoonShine\Pages\User\UserDetailPage;
use MoonShine\Fields\Switcher; 
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Pages\Page;

/**
 * @extends ModelResource<User>
 */
class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Users';
 
    protected array $with = ['messages']; // Eager load 
 
    protected string $column = 'id'; // Field to display values in links and breadcrumbs 

    /**
     * @return list<Page>
     */
    public function pages(): array
    {
        return [
            UserIndexPage::make($this->title()),
            UserFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            UserDetailPage::make(__('moonshine::ui.show')),
        ];
    }


    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name', 'name')->sortable(),
            Text::make('Phone', 'phone')->sortable(),
            Switcher::make('Active', 'active')
            ->sortable(),
        ];
    }


    /**
     * @param User $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [
           'active' => 'required|boolean'
        ];
    }
}
