<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('busca-usuario')
        ->assertStatus(200);
});
