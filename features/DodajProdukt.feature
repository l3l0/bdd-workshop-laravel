#language: pl

Potrzeba biznesowa: Jako administrator platformy chciałbym mieć możliwość dodawania nowych produktów leasingowych, tak
    aby można było dla nich wyliczyć kalkulację leasingu.


Założenia:
    Zasada Administrator ma dostęp do panelu administracyjnego

Scenariusz: Dodanie nowego produktu leasingowego
    Gdy chce utworzyć nowy produkt leasingowy z takimi danymi:
        | Nazwa produktu  | type    | zbiorczy | czy_leasingowy | rating a | rating b | rating c | rating s |
        | LPS Max         | LpsMax  |     tak  |           nie  | 0.5       |  0.5    |  0.5     |  0.5    |
    Oraz dodam go do wersji kalkulacji 1.54.2
    Wtedy taki produkt powinnen aktywować się w systemie i być dostępny dla kalkulacji leasingu.
