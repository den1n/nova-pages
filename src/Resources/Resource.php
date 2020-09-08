<?php

namespace Den1n\NovaPages\Resources;

use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\Validator;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

abstract class Resource extends \Laravel\Nova\Resource
{
    /**
     * Create a validator instance for a resource creation request.
     */
    public static function validatorForCreation(NovaRequest $request): Validator
    {
        return ValidatorFacade::make($request->all(), static::rulesForCreation($request), [],
            trans('nova-pages::validation.attributes')
        )->after(function ($validator) use ($request) {
            static::afterValidation($request, $validator);
            static::afterCreationValidation($request, $validator);
        });
    }

    /**
     * Create a validator instance for a resource update request.
     */
    public static function validatorForUpdate(NovaRequest $request, $resource = null): Validator
    {
        return ValidatorFacade::make($request->all(), static::rulesForUpdate($request, $resource), [],
            trans('nova-pages::validation.attributes')
        )->after(function ($validator) use ($request) {
            static::afterValidation($request, $validator);
            static::afterUpdateValidation($request, $validator);
        });
    }

    /**
     * Creates rich editor field.
     */
    protected function makeEditorField($name, $field): Field
    {
        $class = config('nova-pages.editor.class');
        $field = $class::make($name, $field);

        foreach (config('nova-pages.editor.options') as $method => $arguments) {
            if (method_exists($field, $method)) {
                $field->{$method}(...$arguments);
            }
        }

        return $field;
    }
}
