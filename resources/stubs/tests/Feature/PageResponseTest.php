<?php

it('has a home route response')
    ->get('/')
    ->assertStatus(200);
