@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resultado da Frequência</h1>

    <form method="GET" action="{{ route('frequencias.index') }}">
        <div class="input-group mb-3">
            <select name="escola" class="form-control @error('escola') is-invalid @enderror" required>
                <option value="" disabled selected>Selecione uma escola</option>
                <option value="02 DE JULHO" {{ old('escola') == '02 DE JULHO' ? 'selected' : '' }}>02 DE JULHO</option>
                <option value="15 DE JULHO" {{ old('escola') == '15 DE JULHO' ? 'selected' : '' }}>15 DE JULHO</option>
                <option value="25 DE JULHO" {{ old('escola') == '25 DE JULHO' ? 'selected' : '' }}>25 DE JULHO</option>
                <option value="AMÉRICO TANURI - JUNCO" {{ old('escola') == 'AMÉRICO TANURI - JUNCO' ? 'selected' : '' }}>AMÉRICO TANURI - JUNCO</option>
                <option value="AMÉRICO TANURI - MANIÇOBA" {{ old('escola') == 'AMÉRICO TANURI - MANIÇOBA' ? 'selected' : '' }}>AMÉRICO TANURI - MANIÇOBA</option>
                <option value="ANÁLIA BARBOSA DE SOUZA" {{ old('escola') == 'ANÁLIA BARBOSA DE SOUZA' ? 'selected' : '' }}>ANÁLIA BARBOSA DE SOUZA</option>
                <option value="ANTONIO FRANCISCO DE OLIVEIRA" {{ old('escola') == 'ANTONIO FRANCISCO DE OLIVEIRA' ? 'selected' : '' }}>ANTONIO FRANCISCO DE OLIVEIRA</option>
                <option value="ARGEMIRO JOSE DA CRUZ" {{ old('escola') == 'ARGEMIRO JOSE DA CRUZ' ? 'selected' : '' }}>ARGEMIRO JOSE DA CRUZ</option>
                <option value="BOM JESUS - BARAÚNA" {{ old('escola') == 'BOM JESUS - BARAÚNA' ? 'selected' : '' }}>BOM JESUS - BARAÚNA</option>
                <option value="BOM JESUS - NH1" {{ old('escola') == 'BOM JESUS - NH1' ? 'selected' : '' }}>BOM JESUS - NH1</option>
                <option value="C.R.A. PROFª MAZZARELLO CAVALCANTI REIS DA ROCHA" {{ old('escola') == 'C.R.A. PROFª MAZZARELLO CAVALCANTI REIS DA ROCHA' ? 'selected' : '' }}>C.R.A. PROFª MAZZARELLO CAVALCANTI REIS DA ROCHA</option>
                <option value="CAIC - MISAEL AGUILAR" {{ old('escola') == 'CAIC - MISAEL AGUILAR' ? 'selected' : '' }}>CAIC - MISAEL AGUILAR</option>
                <option value="CAXANGÁ" {{ old('escola') == 'CAXANGÁ' ? 'selected' : '' }}>CAXANGÁ</option>
                <option value="CELSO CAVALCANTE DE CARVALHO" {{ old('escola') == 'CELSO CAVALCANTE DE CARVALHO' ? 'selected' : '' }}>CELSO CAVALCANTE DE CARVALHO</option>
                <option value="CENTRO SOCIAL URBANO - CSU" {{ old('escola') == 'CENTRO SOCIAL URBANO - CSU' ? 'selected' : '' }}>CENTRO SOCIAL URBANO - CSU</option>
                <option value="CORAÇÃO DE JESUS - JUREMA VERMELHA" {{ old('escola') == 'CORAÇÃO DE JESUS - JUREMA VERMELHA' ? 'selected' : '' }}>CORAÇÃO DE JESUS - JUREMA VERMELHA</option>
                <option value="CORAÇÃO DE JESUS - SERRA DA MADEIRA" {{ old('escola') == 'CORAÇÃO DE JESUS - SERRA DA MADEIRA' ? 'selected' : '' }}>CORAÇÃO DE JESUS - SERRA DA MADEIRA</option>
                <option value="DEPUTADO RAIMUNDO DA CUNHA LEITE" {{ old('escola') == 'DEPUTADO RAIMUNDO DA CUNHA LEITE' ? 'selected' : '' }}>DEPUTADO RAIMUNDO DA CUNHA LEITE</option>
                <option value="DOM AVELAR BRANDAO VILELA" {{ old('escola') == 'DOM AVELAR BRANDAO VILELA' ? 'selected' : '' }}>DOM AVELAR BRANDAO VILELA</option>
                <option value="DOUTOR EDSON RIBEIRO" {{ old('escola') == 'DOUTOR EDSON RIBEIRO' ? 'selected' : '' }}>DOUTOR EDSON RIBEIRO</option>
                <option value="DURVAL BARBOSA DA CUNHA" {{ old('escola') == 'DURVAL BARBOSA DA CUNHA' ? 'selected' : '' }}>DURVAL BARBOSA DA CUNHA</option>
                <option value="E.M.E.I. ADELAIDE MOREIRA BISPO" {{ old('escola') == 'E.M.E.I. ADELAIDE MOREIRA BISPO' ? 'selected' : '' }}>E.M.E.I. ADELAIDE MOREIRA BISPO</option>
                <option value="E.M.E.I. ADJALVA FERREIRA LIMA" {{ old('escola') == 'E.M.E.I. ADJALVA FERREIRA LIMA' ? 'selected' : '' }}>E.M.E.I. ADJALVA FERREIRA LIMA</option>
                <option value="E.M.E.I. AMÉLIA BORGES" {{ old('escola') == 'E.M.E.I. AMÉLIA BORGES' ? 'selected' : '' }}>E.M.E.I. AMÉLIA BORGES</option>
                <option value="E.M.E.I. AMÉLIA DUARTE" {{ old('escola') == 'E.M.E.I. AMÉLIA DUARTE' ? 'selected' : '' }}>E.M.E.I. AMÉLIA DUARTE</option>
                <option value="E.M.E.I. AMÉRICO TANURY - ABÓBORA" {{ old('escola') == 'E.M.E.I. AMÉRICO TANURY - ABÓBORA' ? 'selected' : '' }}>E.M.E.I. AMÉRICO TANURY - ABÓBORA</option>
                <option value="E.M.E.I. ANA MARIA MORGADO CHAVES" {{ old('escola') == 'E.M.E.I. ANA MARIA MORGADO CHAVES' ? 'selected' : '' }}>E.M.E.I. ANA MARIA MORGADO CHAVES</option>
                <option value="E.M.E.I. ANNA HILDA LEITE FARIAS" {{ old('escola') == 'E.M.E.I. ANNA HILDA LEITE FARIAS' ? 'selected' : '' }}>E.M.E.I. ANNA HILDA LEITE FARIAS</option>
                <option value="E.M.E.I. ARCENIO JOSÉ DA SILVA" {{ old('escola') == 'E.M.E.I. ARCENIO JOSÉ DA SILVA' ? 'selected' : '' }}>E.M.E.I. ARCENIO JOSÉ DA SILVA</option>
                <option value="E.M.E.I. ARLINDA ALVES VARJÃO" {{ old('escola') == 'E.M.E.I. ARLINDA ALVES VARJÃO' ? 'selected' : '' }}>E.M.E.I. ARLINDA ALVES VARJÃO</option>
                <option value="E.M.E.I. BEATRIZ ANGÉLICA MOTA" {{ old('escola') == 'E.M.E.I. BEATRIZ ANGÉLICA MOTA' ? 'selected' : '' }}>E.M.E.I. BEATRIZ ANGÉLICA MOTA</option>
                <option value="E.M.E.I. BOLIVAR SANTANA" {{ old('escola') == 'E.M.E.I. BOLIVAR SANTANA' ? 'selected' : '' }}>E.M.E.I. BOLIVAR SANTANA</option>
                <option value="E.M.E.I. BOM JESUS DOS NAVEGANTES" {{ old('escola') == 'E.M.E.I. BOM JESUS DOS NAVEGANTES' ? 'selected' : '' }}>E.M.E.I. BOM JESUS DOS NAVEGANTES</option>
                <option value="E.M.E.I. CAIC MISAEL AGUILAR" {{ old('escola') == 'E.M.E.I. CAIC MISAEL AGUILAR' ? 'selected' : '' }}>E.M.E.I. CAIC MISAEL AGUILAR</option>
                <option value="E.M.E.I. DILMA CALMON DE OLIVEIRA" {{ old('escola') == 'E.M.E.I. DILMA CALMON DE OLIVEIRA' ? 'selected' : '' }}>E.M.E.I. DILMA CALMON DE OLIVEIRA</option>
                <option value="E.M.E.I. EDIVÂNIA SANTOS CARDOSO" {{ old('escola') == 'E.M.E.I. EDIVÂNIA SANTOS CARDOSO' ? 'selected' : '' }}>E.M.E.I. EDIVÂNIA SANTOS CARDOSO</option>
                <option value="E.M.E.I. ELEOTÉRIO SOUZA" {{ old('escola') == 'E.M.E.I. ELEOTÉRIO SOUZA' ? 'selected' : '' }}>E.M.E.I. ELEOTÉRIO SOUZA</option>
                <option value="E.M.E.I. FRANCISCO PEREIRA DOS SANTOS" {{ old('escola') == 'E.M.E.I. FRANCISCO PEREIRA DOS SANTOS' ? 'selected' : '' }}>E.M.E.I. FRANCISCO PEREIRA DOS SANTOS</option>
                <option value="E.M.E.I. GABRIELA DE JESUS" {{ old('escola') == 'E.M.E.I. GABRIELA DE JESUS' ? 'selected' : '' }}>E.M.E.I. GABRIELA DE JESUS</option>
                <option value="E.M.E.I. IRMÃ ADILSON" {{ old('escola') == 'E.M.E.I. IRMÃ ADILSON' ? 'selected' : '' }}>E.M.E.I. IRMÃ ADILSON</option>
                <option value="E.M.E.I. IRMÃO ADEÍLSON" {{ old('escola') == 'E.M.E.I. IRMÃO ADEÍLSON' ? 'selected' : '' }}>E.M.E.I. IRMÃO ADEÍLSON</option>
                <option value="E.M.E.I. LÍDIA MARIA NOGUEIRA" {{ old('escola') == 'E.M.E.I. LÍDIA MARIA NOGUEIRA' ? 'selected' : '' }}>E.M.E.I. LÍDIA MARIA NOGUEIRA</option>
                <option value="E.M.E.I. LUIZ DE FREITAS" {{ old('escola') == 'E.M.E.I. LUIZ DE FREITAS' ? 'selected' : '' }}>E.M.E.I. LUIZ DE FREITAS</option>
                <option value="E.M.E.I. MARIA HELENA DA SILVA PEREIRA" {{ old('escola') == 'E.M.E.I. MARIA HELENA DA SILVA PEREIRA' ? 'selected' : '' }}>E.M.E.I. MARIA HELENA DA SILVA PEREIRA</option>
                <option value="E.M.E.I. MARIA HOZANA NUNES" {{ old('escola') == 'E.M.E.I. MARIA HOZANA NUNES' ? 'selected' : '' }}>E.M.E.I. MARIA HOZANA NUNES</option>
                <option value="E.M.E.I. MARIA JÚLIA RODRIGUES TANURI" {{ old('escola') == 'E.M.E.I. MARIA JÚLIA RODRIGUES TANURI' ? 'selected' : '' }}>E.M.E.I. MARIA JÚLIA RODRIGUES TANURI</option>
                <option value="E.M.E.I. MARIA SUELY MEDRADO ARAÚJO" {{ old('escola') == 'E.M.E.I. MARIA SUELY MEDRADO ARAÚJO' ? 'selected' : '' }}>E.M.E.I. MARIA SUELY MEDRADO ARAÚJO</option>
                <option value="E.M.E.I. MARIÁ VIANA TANURI" {{ old('escola') == 'E.M.E.I. MARIÁ VIANA TANURI' ? 'selected' : '' }}>E.M.E.I. MARIÁ VIANA TANURI</option>
                <option value="E.M.E.I. NAILDE DE SOUZA COSTA" {{ old('escola') == 'E.M.E.I. NAILDE DE SOUZA COSTA' ? 'selected' : '' }}>E.M.E.I. NAILDE DE SOUZA COSTA</option>
                <option value="E.M.E.I. NÉLIA DE SOUZA COSTA" {{ old('escola') == 'E.M.E.I. NÉLIA DE SOUZA COSTA' ? 'selected' : '' }}>E.M.E.I. NÉLIA DE SOUZA COSTA</option>
                <option value="E.M.E.I. NOSSA SENHORA DAS GROTAS - CARNAÍBA" {{ old('escola') == 'E.M.E.I. NOSSA SENHORA DAS GROTAS - CARNAÍBA' ? 'selected' : '' }}>E.M.E.I. NOSSA SENHORA DAS GROTAS - CARNAÍBA</option>
                <option value="E.M.E.I. NOSSO SENHOR DOS AFLITOS" {{ old('escola') == 'E.M.E.I. NOSSO SENHOR DOS AFLITOS' ? 'selected' : '' }}>E.M.E.I. NOSSO SENHOR DOS AFLITOS</option>
                <option value="E.M.E.I. PASSAGEM DO SARGENTO" {{ old('escola') == 'E.M.E.I. PASSAGEM DO SARGENTO' ? 'selected' : '' }}>E.M.E.I. PASSAGEM DO SARGENTO</option>
                <option value="E.M.E.I. PASTOR MANOEL MARQUES DE SOUZA" {{ old('escola') == 'E.M.E.I. PASTOR MANOEL MARQUES DE SOUZA' ? 'selected' : '' }}>E.M.E.I. PASTOR MANOEL MARQUES DE SOUZA</option>
                <option value="E.M.E.I. PREFEITO APRÍGIO DUARTE" {{ old('escola') == 'E.M.E.I. PREFEITO APRÍGIO DUARTE' ? 'selected' : '' }}>E.M.E.I. PREFEITO APRÍGIO DUARTE</option>
                <option value="E.M.E.I. PROFª HELOISA HELENA BENEVIDES FARIAS" {{ old('escola') == 'E.M.E.I. PROFª HELOISA HELENA BENEVIDES FARIAS' ? 'selected' : '' }}>E.M.E.I. PROFª HELOISA HELENA BENEVIDES FARIAS</option>
                <option value="E.M.E.I. PROFª JOANA RAMOS" {{ old('escola') == 'E.M.E.I. PROFª JOANA RAMOS' ? 'selected' : '' }}>E.M.E.I. PROFª JOANA RAMOS</option>
                <option value="E.M.E.I. VANDA GUERRA" {{ old('escola') == 'E.M.E.I. VANDA GUERRA' ? 'selected' : '' }}>E.M.E.I. VANDA GUERRA</option>
                <option value="E.M.R.T.I. SÃO JOSÉ" {{ old('escola') == 'E.M.R.T.I. SÃO JOSÉ' ? 'selected' : '' }}>E.M.R.T.I. SÃO JOSÉ</option>
                <option value="E.M.T.I. PROFª IRACEMA PEREIRA DA PAIXÃO" {{ old('escola') == 'E.M.T.I. PROFª IRACEMA PEREIRA DA PAIXÃO' ? 'selected' : '' }}>E.M.T.I. PROFª IRACEMA PEREIRA DA PAIXÃO</option>
                <option value="EDUCANDÁRIO JOÃO XXIII" {{ old('escola') == 'EDUCANDÁRIO JOÃO XXIII' ? 'selected' : '' }}>EDUCANDÁRIO JOÃO XXIII</option>
                <option value="ELISEU SANTOS" {{ old('escola') == 'ELISEU SANTOS' ? 'selected' : '' }}>ELISEU SANTOS</option>
                <option value="ESTAÇÃO DO SABER JOSÉ CARLOS TANURI" {{ old('escola') == 'ESTAÇÃO DO SABER JOSÉ CARLOS TANURI' ? 'selected' : '' }}>ESTAÇÃO DO SABER JOSÉ CARLOS TANURI</option>
                <option value="EURÍDICE RIBEIRO VIANA" {{ old('escola') == 'EURÍDICE RIBEIRO VIANA' ? 'selected' : '' }}>EURÍDICE RIBEIRO VIANA</option>
                <option value="EXTENSAO - BOLIVAR SANTANA" {{ old('escola') == 'EXTENSAO - BOLIVAR SANTANA' ? 'selected' : '' }}>EXTENSAO - BOLIVAR SANTANA</option>
                <option value="EXTENSAO - E.M.E.I. GENTIL DAMASIO DO NASCIMENTO" {{ old('escola') == 'EXTENSAO - E.M.E.I. GENTIL DAMASIO DO NASCIMENTO' ? 'selected' : '' }}>EXTENSAO - E.M.E.I. GENTIL DAMASIO DO NASCIMENTO</option>
                <option value="EXTENSAO - E.M.E.I. MARIA VIANA TANURI" {{ old('escola') == 'EXTENSAO - E.M.E.I. MARIA VIANA TANURI' ? 'selected' : '' }}>EXTENSAO - E.M.E.I. MARIA VIANA TANURI</option>
                <option value="EXTENSAO - MARIA MONTEIRO BACELAR" {{ old('escola') == 'EXTENSAO - MARIA MONTEIRO BACELAR' ? 'selected' : '' }}>EXTENSAO - MARIA MONTEIRO BACELAR</option>
                <option value="EXTENSAO - PRESIDENTE TANCREDO NEVES" {{ old('escola') == 'EXTENSAO - PRESIDENTE TANCREDO NEVES' ? 'selected' : '' }}>EXTENSAO - PRESIDENTE TANCREDO NEVES</option>
                <option value="FAMÍLIA UNIDA" {{ old('escola') == 'FAMÍLIA UNIDA' ? 'selected' : '' }}>FAMÍLIA UNIDA</option>
                <option value="GRACIOSA XAVIER RAMOS GOMES" {{ old('escola') == 'GRACIOSA XAVIER RAMOS GOMES' ? 'selected' : '' }}>GRACIOSA XAVIER RAMOS GOMES</option>
                <option value="HELENA ARAÚJO PINHEIRO" {{ old('escola') == 'HELENA ARAÚJO PINHEIRO' ? 'selected' : '' }}>HELENA ARAÚJO PINHEIRO</option>
                <option value="HELENA CELESTINO MAGALHÃES" {{ old('escola') == 'HELENA CELESTINO MAGALHÃES' ? 'selected' : '' }}>HELENA CELESTINO MAGALHÃES</option>
                <option value="JATOBÁ" {{ old('escola') == 'JATOBÁ' ? 'selected' : '' }}>JATOBÁ</option>
                <option value="JOÃO DIAS FERREIRA" {{ old('escola') == 'JOÃO DIAS FERREIRA' ? 'selected' : '' }}>JOÃO DIAS FERREIRA</option>
                <option value="JOÃO NEVES DE ALMEIDA" {{ old('escola') == 'JOÃO NEVES DE ALMEIDA' ? 'selected' : '' }}>JOÃO NEVES DE ALMEIDA</option>
                <option value="JOCA DE SOUZA OLIVEIRA" {{ old('escola') == 'JOCA DE SOUZA OLIVEIRA' ? 'selected' : '' }}>JOCA DE SOUZA OLIVEIRA</option>
                <option value="JOSÉ DE AMORIM" {{ old('escola') == 'JOSÉ DE AMORIM' ? 'selected' : '' }}>JOSÉ DE AMORIM</option>
                <option value="JOSÉ DIAS CAVALCANTE" {{ old('escola') == 'JOSÉ DIAS CAVALCANTE' ? 'selected' : '' }}>JOSÉ DIAS CAVALCANTE</option>
                <option value="JOSÉ MACÊDO DE ARAÚJO" {{ old('escola') == 'JOSÉ MACÊDO DE ARAÚJO' ? 'selected' : '' }}>JOSÉ MACÊDO DE ARAÚJO</option>
                <option value="JOSÉ NOGUEIRA DE ALMEIDA" {{ old('escola') == 'JOSÉ NOGUEIRA DE ALMEIDA' ? 'selected' : '' }}>JOSÉ NOGUEIRA DE ALMEIDA</option>
                <option value="JOSÉ RAMOS BORGES" {{ old('escola') == 'JOSÉ RAMOS BORGES' ? 'selected' : '' }}>JOSÉ RAMOS BORGES</option>
                <option value="LUIZ EDUARDO RODRIGUES" {{ old('escola') == 'LUIZ EDUARDO RODRIGUES' ? 'selected' : '' }}>LUIZ EDUARDO RODRIGUES</option>
                <option value="MARCÍLIO JOSÉ DE SOUZA" {{ old('escola') == 'MARCÍLIO JOSÉ DE SOUZA' ? 'selected' : '' }}>MARCÍLIO JOSÉ DE SOUZA</option>
                <option value="MARIA JOSÉ FARIAS" {{ old('escola') == 'MARIA JOSÉ FARIAS' ? 'selected' : '' }}>MARIA JOSÉ FARIAS</option>
                <option value="MARIA JOSÉ SILVA DE ARAÚJO" {{ old('escola') == 'MARIA JOSÉ SILVA DE ARAÚJO' ? 'selected' : '' }}>MARIA JOSÉ SILVA DE ARAÚJO</option>
                <option value="MARIA LUIZA ARAÚJO" {{ old('escola') == 'MARIA LUIZA ARAÚJO' ? 'selected' : '' }}>MARIA LUIZA ARAÚJO</option>
                <option value="MARIA MONTEIRO BACELAR" {{ old('escola') == 'MARIA MONTEIRO BACELAR' ? 'selected' : '' }}>MARIA MONTEIRO BACELAR</option>
                <option value="MARIANA DE SOUZA PEREIRA" {{ old('escola') == 'MARIANA DE SOUZA PEREIRA' ? 'selected' : '' }}>MARIANA DE SOUZA PEREIRA</option>
                <option value="MARIZETE ARAÚJO DO NASCIMENTO" {{ old('escola') == 'MARIZETE ARAÚJO DO NASCIMENTO' ? 'selected' : '' }}>MARIZETE ARAÚJO DO NASCIMENTO</option>
                <option value="MATINHA DE ALMEIDA" {{ old('escola') == 'MATINHA DE ALMEIDA' ? 'selected' : '' }}>MATINHA DE ALMEIDA</option>
                <option value="MERCÊS RAMOS DE SOUZA" {{ old('escola') == 'MERCÊS RAMOS DE SOUZA' ? 'selected' : '' }}>MERCÊS RAMOS DE SOUZA</option>
                <option value="MARIA JULIA RODRIGUES TANURI" {{ old('escola') == 'MARIA JULIA RODRIGUES TANURI' ? 'selected' : '' }}>MARIA JULIA RODRIGUES TANURI</option>
                <option value="MARIA MONTEIRO BACELAR" {{ old('escola') == 'MARIA MONTEIRO BACELAR' ? 'selected' : '' }}>MARIA MONTEIRO BACELAR</option>
                <option value="MARIANO RODRIGUES DE SOUZA" {{ old('escola') == 'MARIANO RODRIGUES DE SOUZA' ? 'selected' : '' }}>MARIANO RODRIGUES DE SOUZA</option>
                <option value="MIGUEL ÂNGELO DE SOUZA" {{ old('escola') == 'MIGUEL ÂNGELO DE SOUZA' ? 'selected' : '' }}>MIGUEL ÂNGELO DE SOUZA</option>
                <option value="NOSSA SENHORA DAS GROTAS - BOQUEIRÃO" {{ old('escola') == 'NOSSA SENHORA DAS GROTAS - BOQUEIRÃO' ? 'selected' : '' }}>NOSSA SENHORA DAS GROTAS - BOQUEIRÃO</option>
                <option value="NOSSA SENHORA DAS GROTAS-SEDE" {{ old('escola') == 'NOSSA SENHORA DAS GROTAS-SEDE' ? 'selected' : '' }}>NOSSA SENHORA DAS GROTAS-SEDE</option>
                <option value="NOSSA SENHORA RAINHA DOS ANJOS" {{ old('escola') == 'NOSSA SENHORA RAINHA DOS ANJOS' ? 'selected' : '' }}>NOSSA SENHORA RAINHA DOS ANJOS</option>
                <option value="OSORIO TELES DE MENEZES" {{ old('escola') == 'OSORIO TELES DE MENEZES' ? 'selected' : '' }}>OSORIO TELES DE MENEZES</option>
                <option value="PAULO FREIRE" {{ old('escola') == 'PAULO FREIRE' ? 'selected' : '' }}>PAULO FREIRE</option>
                <option value="PAULO VI" {{ old('escola') == 'PAULO VI' ? 'selected' : '' }}>PAULO VI</option>
                <option value="PEDRO DIAS" {{ old('escola') == 'PEDRO DIAS' ? 'selected' : '' }}>PEDRO DIAS</option>
                <option value="PONTAL" {{ old('escola') == 'PONTAL' ? 'selected' : '' }}>PONTAL</option>
                <option value="PREFEITO APRÍGIO DUARTE" {{ old('escola') == 'PREFEITO APRÍGIO DUARTE' ? 'selected' : '' }}>PREFEITO APRÍGIO DUARTE</option>
                <option value="PRESIDENTE TANCREDO NEVES" {{ old('escola') == 'PRESIDENTE TANCREDO NEVES' ? 'selected' : '' }}>PRESIDENTE TANCREDO NEVES</option>
                <option value="PROFª ANTONILA DA FRANÇA CARDOSO" {{ old('escola') == 'PROFª ANTONILA DA FRANÇA CARDOSO' ? 'selected' : '' }}>PROFª ANTONILA DA FRANÇA CARDOSO</option>
                <option value="PROFª ATANILHA LUZ ARAÚJO" {{ old('escola') == 'PROFª ATANILHA LUZ ARAÚJO' ? 'selected' : '' }}>PROFª ATANILHA LUZ ARAÚJO</option>
                <option value="PROFª BERNADETE BRAGA" {{ old('escola') == 'PROFª BERNADETE BRAGA' ? 'selected' : '' }}>PROFª BERNADETE BRAGA</option>
                <option value="PROFª CARMEM COSTA SANTOS" {{ old('escola') == 'PROFª CARMEM COSTA SANTOS' ? 'selected' : '' }}>PROFª CARMEM COSTA SANTOS</option>
                <option value="PROFª CRENILDES LUIZ BRANDÃO" {{ old('escola') == 'PROFª CRENILDES LUIZ BRANDÃO' ? 'selected' : '' }}>PROFª CRENILDES LUIZ BRANDÃO</option>
                <option value="PROFª DINORAH ALBERNAZ MELO DA SILVA" {{ old('escola') == 'PROFª DINORAH ALBERNAZ MELO DA SILVA' ? 'selected' : '' }}>PROFª DINORAH ALBERNAZ MELO DA SILVA</option>
                <option value="PROFª EDUALDINA DAMÁSIO" {{ old('escola') == 'PROFª EDUALDINA DAMÁSIO' ? 'selected' : '' }}>PROFª EDUALDINA DAMÁSIO</option>
                <option value="PROFª GUIOMAR LUSTOSA RODRIGUES" {{ old('escola') == 'PROFª GUIOMAR LUSTOSA RODRIGUES' ? 'selected' : '' }}>PROFª GUIOMAR LUSTOSA RODRIGUES</option>
                <option value="PROFª HAYDÉE FONSECA FALCÃO" {{ old('escola') == 'PROFª HAYDÉE FONSECA FALCÃO' ? 'selected' : '' }}>PROFª HAYDÉE FONSECA FALCÃO</option>
                <option value="PROFª IRACY NUNES DA SILVA" {{ old('escola') == 'PROFª IRACY NUNES DA SILVA' ? 'selected' : '' }}>PROFª IRACY NUNES DA SILVA</option>
                <option value="PROFª LEOPOLDINA LEAL" {{ old('escola') == 'PROFª LEOPOLDINA LEAL' ? 'selected' : '' }}>PROFª LEOPOLDINA LEAL</option>
                <option value="PROFª MARIA DE LOURDES DUARTE" {{ old('escola') == 'PROFª MARIA DE LOURDES DUARTE' ? 'selected' : '' }}>PROFª MARIA DE LOURDES DUARTE</option>
                <option value="PROFª MARIA FRANCA PIRES" {{ old('escola') == 'PROFª MARIA FRANCA PIRES' ? 'selected' : '' }}>PROFª MARIA FRANCA PIRES</option>
                <option value="PROFª MARIA JOSÉ LIMA DA ROCHA" {{ old('escola') == 'PROFª MARIA JOSÉ LIMA DA ROCHA' ? 'selected' : '' }}>PROFª MARIA JOSÉ LIMA DA ROCHA</option>
                <option value="PROFª MATILDE COSTA MEDRADO" {{ old('escola') == 'PROFª MATILDE COSTA MEDRADO' ? 'selected' : '' }}>PROFª MATILDE COSTA MEDRADO</option>
                <option value="PROFª OSCARLINA TANURI" {{ old('escola') == 'PROFª OSCARLINA TANURI' ? 'selected' : '' }}>PROFª OSCARLINA TANURI</option>
                <option value="PROFª TEREZINHA FERREIRA DE OLIVEIRA" {{ old('escola') == 'PROFª TEREZINHA FERREIRA DE OLIVEIRA' ? 'selected' : '' }}>PROFª TEREZINHA FERREIRA DE OLIVEIRA</option>
                <option value="PROFº CARLOS DA COSTA SILVA" {{ old('escola') == 'PROFº CARLOS DA COSTA SILVA' ? 'selected' : '' }}>PROFº CARLOS DA COSTA SILVA</option>
                <option value="PROFº JOSÉ PEREIRA DA SILVA" {{ old('escola') == 'PROFº JOSÉ PEREIRA DA SILVA' ? 'selected' : '' }}>PROFº JOSÉ PEREIRA DA SILVA</option>
                <option value="PROFº LUIS CURSINO DA FRANÇA CARDOSO" {{ old('escola') == 'PROFº LUIS CURSINO DA FRANÇA CARDOSO' ? 'selected' : '' }}>PROFº LUIS CURSINO DA FRANÇA CARDOSO</option>
                <option value="PROFº PEDRO RAIMUNDO RODRIGUES REGO" {{ old('escola') == 'PROFº PEDRO RAIMUNDO RODRIGUES REGO' ? 'selected' : '' }}>PROFº PEDRO RAIMUNDO RODRIGUES REGO</option>
                <option value="PROMENOR" {{ old('escola') == 'PROMENOR' ? 'selected' : '' }}>PROMENOR</option>
                <option value="RAIMUNDO CLEMENTINO DE SOUZA" {{ old('escola') == 'RAIMUNDO CLEMENTINO DE SOUZA' ? 'selected' : '' }}>RAIMUNDO CLEMENTINO DE SOUZA</option>
                <option value="RAIMUNDO MEDRADO PRIMO" {{ old('escola') == 'RAIMUNDO MEDRADO PRIMO' ? 'selected' : '' }}>RAIMUNDO MEDRADO PRIMO</option>
                <option value="RURAL DE MASSAROCA - ERUM" {{ old('escola') == 'RURAL DE MASSAROCA - ERUM' ? 'selected' : '' }}>RURAL DE MASSAROCA - ERUM</option>
                <option value="SANTA INÊS" {{ old('escola') == 'SANTA INÊS' ? 'selected' : '' }}>SANTA INÊS</option>
                <option value="SANTA TEREZINHA" {{ old('escola') == 'SANTA TEREZINHA' ? 'selected' : '' }}>SANTA TEREZINHA</option>
                <option value="SANTO ANTÔNIO" {{ old('escola') == 'SANTO ANTÔNIO' ? 'selected' : '' }}>SANTO ANTÔNIO</option>
                <option value="SÃO FRANCISCO DE ASSIS - MULUNGÚ" {{ old('escola') == 'SÃO FRANCISCO DE ASSIS - MULUNGÚ' ? 'selected' : '' }}>SÃO FRANCISCO DE ASSIS - MULUNGÚ</option>
                <option value="SÃO FRANCISCO DE ASSIS - NH2" {{ old('escola') == 'SÃO FRANCISCO DE ASSIS - NH2' ? 'selected' : '' }}>SÃO FRANCISCO DE ASSIS - NH2</option>
                <option value="SÃO JOSÉ" {{ old('escola') == 'SÃO JOSÉ' ? 'selected' : '' }}>SÃO JOSÉ</option>
                <option value="SÃO SEBASTIÃO" {{ old('escola') == 'SÃO SEBASTIÃO' ? 'selected' : '' }}>SÃO SEBASTIÃO</option>
                <option value="VEREADOR AMADEUS DAMÁSIO" {{ old('escola') == 'VEREADOR AMADEUS DAMÁSIO' ? 'selected' : '' }}>VEREADOR AMADEUS DAMÁSIO</option>


            </select>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <!-- Tabela de Encontros e Frequências -->
    @if($encontros->isEmpty())
        <p>Nenhum encontro encontrado para a escola selecionada.</p>
    @else
        @foreach($encontros as $encontro)
        <h2>{{ $encontro->conteudo }} - {{ \Carbon\Carbon::parse($encontro->data)->format('d/m/Y') }}</h2>
        <table class="table">
                <thead>
                    <tr>
                        <th>Participante</th>
                        <th>Escola</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($encontro->frequencias as $frequencia)
                        <tr>
                            <td>{{ $frequencia->user->name }}</td>
                            <td>{{ $frequencia->user->escola }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif

    <!-- Botão para gerar PDF -->
    <form method="GET" action="{{ route('frequencias.gerarPdf') }}">
        <input type="hidden" name="escola" value="{{ request()->input('escola') }}">
        <button type="submit" class="btn btn-danger">Gerar PDF</button>
    </form>

</div>
@endsection
