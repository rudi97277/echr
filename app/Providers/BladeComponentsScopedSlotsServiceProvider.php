<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeComponentsScopedSlotsServiceProvider extends ServiceProvider
{

    // special thanks to 
    // https://github.com/konradkalemba/blade-components-scoped-slots

    /**
     * Bootstrap services.
     */
    public function boot():void
    {
        Blade::directive('scopedslot', function ($expression) {
            // Split the expression by `top-level` commas (not in parentheses)
            $directiveArguments = preg_split("/,(?![^\(\(]*[\)\)])/", $expression);
            $directiveArguments = array_map('trim', $directiveArguments);

            // Ensure that the directive's arguments array has 3 elements - otherwise fill with `null`
            $directiveArguments = array_pad($directiveArguments, 3, null);

            // Extract values from the directive's arguments array
            [$name, $functionArguments, $functionUses] = $directiveArguments;

             // Wrap function arguments in parentheses if they don't already have them
             if ($functionArguments && !preg_match('/^\(.*\)$/', $functionArguments))
             $functionArguments = "({$functionArguments})";

            // Connect the arguments to form a correct function declaration
            if ($functionArguments) $functionArguments = "function {$functionArguments}";
            
            $functionUses = array_filter(explode(',', trim($functionUses, '()')), 'strlen');
            
            // Add `$__env` to allow usage of other Blade directives inside the scoped slot
            array_push($functionUses, '$__env');

            $functionUses = implode(',', $functionUses);

           return "<?php \$__env->slot({$name}, {$functionArguments} use ({$functionUses}) { ?>";
        });

        Blade::directive('endscopedslot', function () {
            return "<?php }); ?>";
        });
    }
}
