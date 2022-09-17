import re, time, requests
from Scrapping.filtros import filtros

def amazon(busca):
    data = {
        'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.64 (Edition std-1)',
        'cookie': 'session-id=132-5485164-4207150; i18n-prefs=BRL; ubid-acbbr=131-9085882-2904223; session-token="XG43BxPMjBrd/1gXZ86NimnV0+isMcrQCIL3+T2cHVbjIymA6zjriym7Nqkmyz5UjaTQoefqqlToEtoHMT6pq0oxqifzYHcuNVb0nXrfiqsF+RJ5+lC2TaHkXeV/SDcWc+X99gRzOeJ5L1uVHTNoCEAkQ2aSSQsOV9OBtZBhyhqC4gl09r+eLA2HCVaGvDnk0cFKqvPSNotGgYRhpcCpz+P7Bhalj/KXeJI3IOCuw9w="; csm-hit=FKVEYF4FV0T1PKRYNP7J+s-FKVEYF4FV0T1PKRYNP7J|1659737475630; SLG_G_WPT_TO=pt; SLG_GWPT_Show_Hide_tmp=1; SLG_wptGlobTipTmp=1; session-id-time=2082758401l; csm-hit=7K0NS1KA3WGP132NRWKT+s-7K0NS1KA3WGP132NRWKT|1661180162803'
    }
    res = requests.get(f"https://www.amazon.com.br/s?k={busca}&rh=p_n_condition-type%3A13862762011&dc&__mk_pt_BR=ÅMÅŽÕÑ&qid=1663012871&rnid=13862761011&ref=sr_nr_p_n_condition-type_1&ds=v1%3AQICdAhBztI8aDUARnxSe1z0CzOQ0JnYcthQI6YXBkao", headers=data)

    links = re.findall(r'class="a-link-normal s-underline-text s-underline-link-text s-link-style a-text-normal" href="[\w\-%\/=?_&;+.,]+', res.text)
    links = [reg.replace('class="a-link-normal s-underline-text s-underline-link-text s-link-style a-text-normal" href="', 'https://amazon.com.br') for reg in links]

    produtos = {}
    protecao_duplicados = []
    quantia = 0
    index = 0
    data["rtt"] = "100"
    for link in links:
        # PROTEÇÃO PARA NÃO DUPLICAR ITENS
        if link in protecao_duplicados:
            continue
        protecao_duplicados.append(link)

        #WEB SCRAPPING
        try:
            if quantia >= 15:
                break
            dados = requests.get(link, headers=data)
            titulo = re.findall('id="productTitle".*<\/span', dados.text)[0]
            titulo = titulo.replace('id="productTitle" class="a-size-large product-title-word-break">', '').replace('</span', '').replace('  ', '')

            preco = re.findall('class="a-offscreen">R\$[\d,.]+', dados.text)[0]
            preco = preco.replace('class="a-offscreen">R$', '').replace(",", ".")

            capa = re.search(r'large":"[\w\d\/:\-%\/=?_&;+.,]+', dados.text).group(0).replace('large":"', '')
            produtos[str(index)] = {"nome": titulo, "preco": preco, "link": link, "capa": capa}
            quantia+=1
            index+=1
        except:
            pass
    print(filtros.menor_pro_maior(produtos))
