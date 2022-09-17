import re, requests
from Scrapping.filtros import filtros

def ml(busca):
    res = requests.get(f"https://lista.mercadolivre.com.br/novo/{busca}_NoIndex_True#applied_filter_id%3DITEM_CONDITION%26applied_filter_name%3DCondição%26applied_filter_order%3D4%26applied_value_id%3D2230284%26applied_value_name%3DNovo%26applied_value_order%3D1%26applied_value_results%3D416%26is_custom%3Dfalse")
    links = re.findall('<a href="[\w\-\/?&;=:#_.,\sÀ-ü\d%+]+" class="ui-search-result__content ui-search-link"', res.text)
    links = [item.replace('<a href="', '').replace('class="ui-search-result__content ui-search-link"', '') for item in links]
    produtos = {}
    protecao_duplicados = []
    quantia = 0
    index = 0
    for link in links:
        if link in protecao_duplicados:
            continue
        try:
            protecao_duplicados.append(link)
            if quantia >= 15:
                break
            conteudo = requests.get(link).text

            titulo = re.findall(r'application\/ld\+json">{"name":"[\w À-ü\d,]+', conteudo)
            titulo = str(titulo).replace('application/ld+json">{"name":"', '').replace("[", "").replace("]", "").replace("'", "")
            preco = re.search(r'R\$[ \d.,]+"', conteudo).group(0).replace('"', "")
            preco = str(preco).replace('R$', '').replace("'", "").replace(",", ".")

            capa = re.search(r'image":"https:\\[\w\d\\.,_\-%@:]+', conteudo).group(0).replace('image":"', "").replace('\\u002F', "\\")
            link = link.replace('"', "")
            produtos[str(index)] = {"nome": titulo, "preco": preco, "link": link, "capa": capa}
            quantia+=1
            index+=1
        except:
            pass
    print(filtros.menor_pro_maior(produtos))
