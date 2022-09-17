# FILTRAR PRODUTOS DO MENOR PREÇO PARA O MAIOR
import re

class filtros:
    def isset(lista, pos):
        try:
            lista[pos]
            return True
        except:
            return False

    def menor_pro_maior(lista):
        index_price = {}
        for index in lista:
            preco = lista[index]['preco'].replace(" ", "")
            pontos = len(re.findall("[.]", preco))
            preco_split = str(preco).split(".")
            # 9.999.99
            if pontos >= 2:
                preco = preco_split[0] + preco_split[1] + "." + preco_split[2]
            # 9.999
            elif pontos == 1 and len(str(preco_split[0])) == 1 and filtros.isset(preco_split, 1) and len(str(preco_split[1])) >= 3:
                preco = preco_split[0] + preco_split[1] + "." + "00"
            # 9 / 9.99 / 99.99 / ...
            else:
                pass
            index_price[index] = float(preco)

        menores = sorted(index_price.items(), key=lambda item: item[1])
        lista_sorted = {}
        for index, item in enumerate(menores):
            lista_sorted[str(index)] = lista[f"{item[0]}"]
        return lista_sorted
