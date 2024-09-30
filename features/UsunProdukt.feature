#language: pl

Potrzeba biznesowa: Jako administrator platformy chciałbym mieć możliwość dodawania nowych produktów leasingowych, tak
    aby można było dla nich wyliczyć kalkulację leasingu.


Założenia:
    Gdy mam produkty leasingowe z takimi danymi:
      | Id                                    | Nazwa produktu  | type    | zbiorczy | czy_leasingowy | rating a | rating b | rating c | rating s |
      | f1b9f4b0-0b1e-4b7b-8b3e-3f0b6f1f5f7d  | LPS Max         | LpsMax  |     tak  |           nie  | 0.5       |  0.5    |  0.5     |  0.5    |

Scenariusz: Usunięcie produktu leasingowego
    Gdy usunę produkt o id "f1b9f4b0-0b1e-4b7b-8b3e-3f0b6f1f5f7d"
    Wtedy taki produkt powinnen zostać usunięty z bazy danych i nie być dostępny dla kalkulacji leasingu.
