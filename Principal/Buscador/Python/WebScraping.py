import sys
from Scrapping.mercado_livre import ml
from Scrapping.amazon import amazon

buscar_por = sys.argv[1]
area = sys.argv[2]

if area == "mercado_livre":
    try:
        ml(buscar_por)
    except Exception as e:
        print("Um erro ocorreu.")
else:
    try:
        amazon(buscar_por)
    except Exception as e:
        print("Um erro ocorreu.")
