<div class="clearfix float-sm-right">
    <button class="btn btn-success btn-sm transaction-operator-top" wire:click.prevent='OpenAddCashForm'>
        <i class="fas fa-plus"></i> Cash
    </button>
    <button class="btn btn-danger btn-sm transaction-operator-top" wire:click.prevent='OpenNewPaymentForm'>
        <i class="fas fa-cart-plus"></i> Pament
    </button>
    <button class="btn btn-info btn-sm transaction-operator-top" wire:click.prevent='OpenNewExchangeForm'>
        <i class="fas fa-exchange-alt"></i> Exchange
    </button>
    <button class="btn btn-info btn-sm transaction-operator-top" wire:click.prevent='OpenImportPaymentForm'>
        <i class="fas fa-file-import"></i> Import
    </button>
</div>
