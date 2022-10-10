<?php

use function Pest\Laravel\artisan;

use Symfony\Component\Console\Command\Command;

test('bot id is required if there are more than one bot', function () {
    bot('AAAAA');
    bot('BBBBB');

    artisan("telegraph:new-chat")
        ->expectsOutput("Please specify a Bot ID")
        ->assertExitCode(Command::FAILURE);
});

it('can create a chat for the default bot', function () {
    $bot = bot();

    artisan("telegraph:new-chat")
        ->expectsOutput("You are about to create a new Telegram Chat for bot $bot->name")
        ->expectsQuestion("Enter the chat ID - press [x] to abort", '123456')
        ->expectsQuestion("Enter the chat name (optional)", 'Test Chat')
        ->assertExitCode(Command::SUCCESS);
});

it('requires a chat id', function () {
    $bot = bot();

    artisan("telegraph:new-chat")
        ->expectsOutput("You are about to create a new Telegram Chat for bot $bot->name")
        ->expectsQuestion("Enter the chat ID - press [x] to abort", '')
        ->expectsOutput("Chat ID cannot be empty")
        ->expectsQuestion("Enter the chat ID - press [x] to abort", '123456')
        ->expectsQuestion("Enter the chat name (optional)", 'Test Chat')
        ->assertExitCode(Command::SUCCESS);
});
