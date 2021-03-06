<html lang="en">
{{--<head>--}}
{{--<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">--}}
{{--</head>--}}
<body style="font-family: 'Open Sans', sans-serif;">
<div>
    <style>
        #logo{
            background: rgb(255, 102, 0);
            width:100px;
            padding:20px 0 20px 0;
        }
        .header{
            float:right;
            margin-right:50px;
        }
        p{
            line-height: normal;
            padding: 0;
            margin: 0;
        }
        h4{
            padding:0;
            margin:0;
        }
        .page-break {
            page-break-after: always;
        }
        .page-break-avoid{
            page-break-inside: avoid;
        }
        .picture{
            margin-left: 45px;
        }
    </style>
    <div style="margin:0">
        <img id="logo" style="margin: 0" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAABdCAYAAADg8yluAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjkzMDhGRDcwODZDNjExRThBMTk4REYxNzg3Njk0QkIzIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjkzMDhGRDcxODZDNjExRThBMTk4REYxNzg3Njk0QkIzIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6OTMwOEZENkU4NkM2MTFFOEExOThERjE3ODc2OTRCQjMiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6OTMwOEZENkY4NkM2MTFFOEExOThERjE3ODc2OTRCQjMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz48v+OGAAAj0klEQVR42uxdB3xUVdY/M5NJmfQESAIkgVCkhCJSFJWOrFJUXAsKrGDbZW2ffuuuruvq7lrXttZF/RTBioiKNAUVQTpSpIWWQAJJgBTSM0lm5jvnzf+Rl8fMZEIQQvLO7/f/ZTLvzX333XvOPeWee6/J5XKRQQYZ5JnMRhMYZJAhIAYZdFoUYDQB9WNMZFzACMZ3Ld3ulIHTybAz9jE+Z/xsCEjLfP/+jKGMHowQMEdLFxATBKSC0Y5xkLGNUdPiGqIFO+mtGP9g3MyINBSpTzrB+IDxKKPIEJDmT2GMdxg3ar7bwNgMZjABLZFc0B4xMD8HaK69z7iTUWUISPOmexn/weejjH8zPmUcNpRFHUpkXM94iBGH7/7A+K8hIM2XQhnLGJdgJLydMceQBZ80lfE2I5DxI2MCo7ilRCtaGqUyOuDzYsZHBv/XSx8zVuBzT8aglvLiLVFAkhix+CyjocPg/3qpGm1F8E1aGQLSfMkKCOUZvO83ZWs+OwwBab5USO4ojdAJg+/9JrWtnC3F/xBqyERhJEZe53n6rjLqVTJaU+1EYDzDhnawkjFB6Kvd1CiWhL/bwGG3nWeDrBq6l/cp8+sH9USxJPViDGMIoxcjHEx0PjKSCLZErSR02QXfHWAcgnBYDFnwKiAyg57MSMF3exhZ5M48MJ2HAnKc3PNe3zI2nq6ASOrFvxijyT2xZpBBzY2OMGYznmKUNkRAupF74qy35rvtjN1QT+fzaKvVgC15xvx0tfD56ruqGQLR4OtkzbX3GPd4Mrs8+SCiLf6qEQ7J5nyG3JNrBVC5Rpq8QefrwCi+U1vGJMZ98K2nwWz8AFrFqwbpSO78m1kQFPmRJPNtNtrXoGZIklf2CiMIfsmLUAYnSa8JhsApV32OdwzhMKgZkyiCRfgs0c0B+hv0AtIF/oeQTAytNNrQoGZMEtX8RuOTBtcnIBK2s+GzGgI1yKDmTJLBXertol5Aaqg2jUD72SCDmrPzXuOvgGhDoBLhMibPDGruJDxu8ldADDLIID81iEEGtSQzizzxvl5AAqh28tBMxiyzQS1DSQRo+N+ngMhyVHWHj3DDBzGoBVAgeF3l/1M0hpZkczCJXEnu/yryMyXYIIPOY8pkLCR3pvIP+ov6VBMrhEakSnbVqzTaz6BmTmIlhYDny8D3XgXEIIMM8uGDGGSQQT58EMnDkh0r2pN7xZistqoymsmgZkySpHgx+H4nuVcaehWQW8m9kbP8QLZ5ka05jxptaFAzJtnjSzYOlOjt1+TeFM+riSVhrgh8NsK8BrUECqLa8G5EfSaWePElms9GsmLjyYQOkCiJREQkSlLeiPJsKEudxK1BeWeyryyocwDqXA1+cDWyHSRaZNUMzFL3Cjq3xypIf0g2bxT5ueTWoMaT2LNy7khfcu8G0xZMpzKbpFjLeRs7GGnw9/QkzJQCf1C2J+pE7hWfcRj1VGaVddayFDqD3CtAxY7eCsZrCCWhvn3Ivdy6tUYIHTC10wBZCiFLsb0dhRCG+iYA8rkz2kWbHCh1L0RZUnfZ92AzNaGtpQwBObNkgx83RcMQvkiWecoa6CWMeYwtYHwRjCfJvcItAgwX4sfzq1CmTPi+RLX76foi2eNKlp7+ltwbGUTVc3+Jhqm/YHxJdddxizA8y7gIWsjfutshhDJZ9wo1lZWsMg+iwTOMdS43rWTE6a4b8I5UxgLX6VMGYxLKGu9qPGUz/lBPnXswljfyOW8xQjVlXn8G6p7O+N1Z6rdxjEI8d5H+ujEPcmZINrr4hDG+EWV0YIzSjKaN9SnEtHmd8Xsv12V5teziMbKRzxFNEaPzNaobWaaYknIGyQ2GiXX+k3SmbG7Rsx6zpEbjqAZ5uU/1G6pxv6coYo1GgEzowxAfjvFj5J7P+lnnI4gJd6GX35XDjBKnNRhmXiR5zu4u0vkMNYDVw73VqLvqP1nJwzpwkHz/ONXux2YIyHlIwjgv+GA0mXRawNhE7g2fhSFk69NLGYMZ3RGR0voQKnMEaZg1h3GIVf52k8m0Hba6HdGgMGgD2ZFmhAfhE00yGf6NysgS67/eC7N/hjrv0whIPBz4YdCWHXy0SaBGYMvgnxyAc78DdVcHCxE62cHzMiBQV5a0z40QFENAPDR0Ehq7CkzibVfxaHSiBZ2SdZZCh+KQX+vhe2HEp8l9tJunSM+HcIbHMmZAWITUtOtsRKKEmWYx1jCOOZ3OyiNHjtD+ffsoKCiY7PZK6tKlC7Vt144sFsvzfM9tEFh92vZQOP770a6jPdRJMrjlaDpPp22JsKyCydYBps9tCERE6zRLFrRVLuNdxjpGXmlpaZU1IIBKy8spIjycNmzYQKUlJRQfH099+vYNqqmpuS8gIOBJDzzZH+1S0hIFJBEjRCJMhvmM9YyrGNcg3KjGp/cgKjMXkRr193LfcHKfc65uACYj1VJEWFRTRKI0l2hGr9W47ouEqSbBxjaj08Wcyke49Tovv5MNyB6tp+wTEBSpp+xkeYdGqCUELPuTFWZlZVUfOniIvv/uOxECOno0h/btkwGZ/zWbHSkpHSkyKkqEpObWabfODA4O6cda5k7dszojQrUf7dnRQ31WUP1H0Yngp5N7c7UleEdJFy/Vac0rEXp25OTk0OxZs6i4uJgcNTUUFR1NFXY7rV+/nlwOBwUHB9PE666zT54y5UX4YKM9+GZS319aooD0R2OrtvYQxPFv8GCb9gKTixnxR8Tp3yJ3Wgzpwozy3e0YTf8MIbmO6p5qK//vYuz1Ub/fwYZXqRDOeD5Mjf5eGO0fDWgDKesBcu/PdHKUdJHr2JrVa+jDOXN4pC2lqurq+PLysotNZOofGRUZ56iusQRarWU52dn7srOzV6/+afXP/D/ddscdCxG21VIo1W7nFODFBwpsYN9tg5kWSHXz9cTPOL79l19o0aJFVF5RQUcOHw6sstuH2O32Pr3Cwj7MZUpKTExggf/zwYMHyzPS01/gz9IO33kQkEg/Qs/N2sSyazrvIsAXTcSIHgW72Bc9CBv4JWiLGzTmQEeMWHt9mG1DdN/JWX3qSbgDNPXW0vunaQ58o35I272bNcb3tHvPbgoLC4uurKy8lZlrfFJSUv/4uPjw0PAwspgtZK+spILCAsrJztlfXFzyw84dO58rKS2pDg8Lt+uEwKV5b9VR1pP4AP+L6FFpA+p9UjjK2XzKyMigXbt20coff6TMgwcpPiGBIiIiUisqKt4JCgpK5ndpw4L8GJuLk1xO530RYWHEWvKHRQsXLhs7blyGj2BDixSQKjihnhitGBEMmwcneJju/3QIQjL8Fi1Nhx0v5ttPjMt15Yid7Glh2ECqu7t9FcKiDjjnvT38Jhfm3WnTrl07acnCxVRSUkZhoaEXZhxIfyo8PPw3Y8ePp4v69aN2ie3Z/wgiNqMUk6WoqJj2pKV1Xvnjis7r1q4f9O5b72Tfe//91SazSS8gLo0jngG/RB9weBpm6HKYtLnwh+o9iWvd2rW0ePFi5XNBYSE5nQ5KTEoKJJerqpK1SE11dRsGpaenz6iorOwaFBjYNzAwkMLYH8kvKGg9+/3Z7FPZezLRBd26kZe6t0gNYvJiprwAZy8Ips4jHswA8U3ehC2fC3v1UTi/Wj9HOn0x7GatgFwOU2mNhzr8hurG97/X2MHhXtR+FsywBpM4rNt37CAxTSIjI6my0t5v9+4Dc5jJekybNo169url8XehPAK3bdeWLh58CX360ce9P583r3dEVKRz2vTpvgal5QgweOKHiUAe2nQvBqosRKN2kIezHcWnKGTBiGOnO65NG9vR3Nw72LwaGGazzTeZzUnsg1QwQthvCmOhuEY4voT9EjP7Va1iY293OBxD333nnQmt27Sh38+YQYMGNY2DdJtiFGszRn2tun0WjvhQ3cgiptPfdCP4oxAIlbltmrCkbFR8H9UeJxYPIVnjwTnXa6kFVJvM5m1TPTFN/MqBEmbatm0rFRYUUmBQoOJn5OUdp1atWlNhfkGbtLS0N1NSOvW4/8EHKC4ujjVKCa1ft45qWGsEBAQoo4rT5WQzy04pnVKoR89UuvW26RQYHMSC8ok5Pj6BrrzqSm+P/wrh3Ot9VLEVkAqBIWhpiWithOY9uTVtt+7diV0LpW5s+vWqKCt7kv2mULvFMrGouLimxuEI6z9gAPW78EJKaNeO2LyizMxM2rhxI+1NSxvO9R5u4d+eOHGCtWJRk2HGpiggH+mEQ7Wb03QCIh0128PvMzHSqQJipdrd6n9B9Gqi5n6ZSX4bURdtWLS3rszVmv8tXpzaKn/Cy8IY8z+fR1Z2qi0Wd8KsMFZUVJSS3rBv/74ZVmvAwGm336YIh9C8uZ/Rl1/Mp5CQEP5dgKJ4xcwShmrHDPfnhx+mDh070s233CJOMX02dy71vbAvJSQkkBdBfgBacHQD+qYdIIOHzKU8DmGjwYMH05qffiIHm1H8XpkhYWGLqazs+mPHjgUH22w0les1ctQoCg2tjUAPGDiQhg0bRkvYNPvyyy/JXmWncePG0xVXXNFkmLGppZoIc3maNbXQqekLh73MMQR58Cm0o/1SXVkyB9FHN2gM1bXNd4h4abWX00t71utQlpWytjiez452ACxsE9voDqoor6TcnNyU/Ly8KSNHjaCuXbu6/ZKdu+inVauUMK/Y7SaThcxmE8NM7J9QFgvE119/fbL8G2+6ics2K4zng6T9JkM7HzuNvuqLgIQy2BQXl1BpWRnl5eezVizIiYmJeZ61Rp5seXDTpEk04eqr6wiHSrGtWtHkqVNp3IQJilY5UVBAe/fsIQkPs2NvCIiOCnQjuZYhyYNWMfnp17h0ptJuXQhUO4r2ptqcKIJT/r1OMzi8aIoAf7SymCNDhw2ljRs2kEz8iUkhkLmCw1lZl0XHxKRcPtStLMWEWrTwazbJCig2NpZsrEGC2YyS+QMRFvFXIiIiaP3adWyCrVd+k5ScTKnss2z5eTMdP+aT9+XiX8g97/QEuVfU7fLSB54oEmH6bgcz0hWBZQ3Ytrik5Df5+fm3snYLG3TxIBo7dmy9BV07cSL17z+ANm/eTI8/9hjdd889tHjhQsPE8mCi+LsWoCHnC2oFRE2p1ppQkmT4MhjmUpgRWp/oR1153gQkmvw48FRMo0svu5QKeLRMT09XwqIS4WHn1eSoqR6UmtqL2ie6g3ErV66kTRs2KgIhGkRGWeWFXO5y2LmVaJciCItYi6T2SlVG6u49utNOdvozMw+ROL710M+ADBYyv9QVGqI72qITIoSe/K4ukoW8+qdVf2fNFxwUHDy7urp6RN6xYyYR4MGXXaaYj/VKGgv5xZdcorTFkexsKuYBI+foUcXklPc0BKTWFDI3QEBOl75GFEfdRVLiij0hIHqbfBmduqCp2EvoU4IBsf5UwGYLVUyhyspKxSf59ptvaM3qNdbqqqqereNak5mZQr7/6sv5VFVVRa2jWrtTsCFgbiFxy72YU6JJdmz/hRawLT+J7f1EFjBhUHGcG0BlwEFyH5Gshn9FQGTe5zaEv/V0kZlMFjatWBhbt2UhNrGDTvFsPrVr29bvhyfwvTIIdOncmYaPGEGXDRlyToWjKZpYZ4skeXCbbqAYBn9EGwYuhIDoqUT3e5XE6b24IRURzSC+xt1sUkyZMtlst9vDXdCh4mxnHcoka6CVJI9JFQh1rYJKTv4cHBJMFSxse/bsUb4L4f9N7KdUVjR67z8ZDCTRUbIW/ojgiF4jxl45blwCa4HKvON5NwcFBT0dYLVmmGT0b8CD5J3EP7uATdBbpkyh5ORkwwc5R1SkGSG1ZtYMqju/sQnM4Yk2kucZ5zsx4jaExAaa3CO155DIqOiDbKooX/bsmUoDBg5SkhLtrEWU0RQjqpbxTKxBSopLFR9FIkXKC8pkncNJXJ7+WWIC3kXuuaXTGVhWedLmPVNTg6+7/nrh8q3BISGPhIeFLZAIW04DNNhRvtfF75d16BD7VGuprKzMEJBzSEuoNm2EEMn6re6e5eR93fUWqrvGQiVJmvw3/BF/SLxxCW3Pjo1tNTw+IX5NztHcckkjiYiMoKsnXqvMjcg8iDtfpO6oLI6x+C8VlRWKDX/5EHd2zIH0DGJfgNrWmjgujTBKcqScDf4audPN/aVQqnu+uHbAKerWowcN5uc7nc6LuV6DJaolWbv+kESsNm3cqJiLMmH69NNP05bNmw0BOYe0TWc+malu/lKuB+dcHwH60EuETVLgZ8Nc8zRf0gom3QuIqslcjCksLKw8JaXDRjatytPS3KZSr169aOjw4coEYbWiRcx1cy94xJUImMyXjBs//qSpsnPnDoqJiWYzJclT3dWM5j9SbVaumIbh9USsHiL3hK2eZLY9T0zCkuLiRDYTZ3FdB4TabMrk5vLly+vtjKVLltD27dspNiaGWrPvEhUVqaTFG1Gsc0cOmFm3eGFimRisL8V6Dpj7Rg/XxsGhXQWnV9azyKx+EkbhgZogwUl3grXF5pLikm3fLV8+sk9f9/TMmDFjlNF0z+7dFB4RoZhaYt+z+qAKHqXFBxk1erQyUajYfjxq72EBk0lDSUXx8N5a01Dq808Ii2hEmZDdicCE3BuPaNZg8rw8V4IVX7BQuMRJZyGvZiY/wvVKjoiISM/Lz283Z/bsSIm+ieOtj2iJGbXsm6U0a9b7FB0dTVOnTmWN2YpkVl3WurR0AdEnorn8DNWeqXsleVFyi/p5uCbCU99MlXjAjyAClurFt7jOb4l1OBIrKytL27Vt+59NGzaMXPHDCho2fJiS33TVuHFUwppCGEeSFRVfhAWj0GIhMW3GXHWVUkYpO7nvz3qP4uPjaMTIkZ7aWZtZoCURhLGACxrUibCvr1T4mYzv8/PzaRcLcFJSUi6bSXceOngwJTAo6HBKSsrErMzMx9+aOTNg65bN1K9/f2rXLpGf4KT0jHRav3oNbWPNIblonVNSFI2pC0u7WrKAiEkTorNxrV5MQX3Gr81L/S1e7vVEhyEIegGRybIVfr6DZBLfjihP70bZu2azqXefPpSbe/Rre9rud+fMfn96aKhNSckYzRqiU6dOiqkldroIiIzK8r+ER2UuRITjhWefo7y8fPrbY39XIlua9lPNaacf/S7mV4IfVRYz8jn5IAGC7iyoOdnZ5HA6D0RGRR2I43rxQ/dIvUSAflzxI23cuEkxnSSwcKKwUMLcJZHR0TU2my16//79tHr1arrm2mv1PGpuqQJi0jGvt/o46dR5Dyt5n1QMbICvtQBmVqJOe+xtwHvIFPZN5F5PMYn82wdKSxJOXsSm07sd2UyqcdTICsEH9qalWV9/9dUp4ydMoDFXXkk8GnstYMf2HfTRhx9Q+oEDSshYJgx1g0aYZlB4DtG2XqfZbzLT/jrKUcw10Wpt2A86mJGhBA3EtHM6HOIfDa6urg6IjompDrRaXysvL3cWFBTcJcmLLCilcQkJMpOfxsLycLvExFGSV+bB9wlsqQIikaCnyD3BZqLanQb1JGklH0MggmEbS37UcQ/3Soz0JUSHrOjMRT7qUE51c7MktvjDabzLbjDd5+ReBiw2e4oPYSmGplpL7olLySi2SzSnnO1ys8VclJSc9IcTBSf2ff7ZvLu3/Ly5zUWDBlCnjilK6JavK5OMEhrd8ct2Wrt2rbMgP+/T6XfcseXyIUMkP6o9TMRwtIG6uVsVolcyMFyJYEFv9IGtHnNyP3yzjz0FMEQwZGY/7/hxZT6jnMH+0ZIAq7UzO+wb2f/4J/soFBEZeWFxUdEIW2joTjbD3mMhqmDfascNN9xwL2vLyZp6RoFHDrdUAclABEWNHtl93LscjBsAQan20ZESwvwAI6e9Hjv2Cqq7yErikt83wvFfDA0kwtEVf2M1o2Al1a6zkKzjTA+mljL6WiyWsrbt2/0z73jetxkZGRMzszKvYEbqEhpiC2Abhaqr7a7iktJiFirxpRYmdegwPzk5WUKusjgsBkwWiFE+XfeYTPgPH0B7dkJdW0FQrHgfOwYiEY49+Os1HUgiaE42/cSEkllxs8u1jDXjOqvVWqG8l0vJXJ7JcJgtls/YXKwwuTXQsTZt2sjShXnotxoMhscR5GjRUSx7AxjQ3w3Vqqn+DcwSYRoF6ASxtJHvUwMB2NuYQpzwMWy20PXMYOuZ+d6oqqlKPpKbE+WoqrGEhYVWsuhnR0fHHODrpQ42zcorlH2xDwD+UBnV7rmrN8ucp+Mka9NDXG6hKRHBEYFhFSMdODfAYvnWarGUiCBJ2r+8K2tEuX1rUwp1trQwr8T6B2E0lc64Q+egy/efNLVKy/JVYbCg4OBDIZaQQ+JSVVVWUWRkBFVV2ZX0dzFtzvBxemd8Z/+T9XOnypxw6b9vgtTSBGQsTLoqL878Bx5MkSYkKE539OpkTpbT/dlknDNpCMiZoVIvgiG0Ec6rQadJSoChvFzxoZoLtbRUk93keR2HJOHd4yUqdlZJTCW73X5eMpmEqCUDN/vIEcV3ag6C0tI0iIQmZeWchDfVpbkyh/FGA5zaX5VkzbmEQmWhE9tUFBxiU/bAOh+YrVu3btS5c2cqKymhDevXK2kkMvMvQi/1l7kSp7M2ACbfSUKl5JKFBAcbAtIESEKg/yL3Jg0yay8hn9ymVEHJR5oxY4ayWEqiO2vXrFGW0gojKY56SCBVV7l3M7GYTZRfkM+MF0K2UFutT3IuGYoF4u777qOVK1bQgq++UrZFdbBQyNyOLC+W95OVlJK3ZWUkJiVR1wsuULICmsIa9JYuICo16ZN7Y2JjFQj1TE2lzl260tIli5WND7JzspVdF0OCQ6h9+wS6Zepkyso6rGzcJqsQRZCaAg0ZNkzByQY/epSWL1um1FMyAyQhUcywjikpitaRVZOyFVJTI5NuxJEF+PJWEgqVLNTryTgGukmQdm12RUW5kvYuS2pV00ucY9mITXpTdkxvslGS0lLFhGxCJFnXkpUts/YyyTvW0CDnIWkn30JCTs0IsdlsCpo6NTHhqJeMI9gMMsgQEIMMMgTEIIPOqoA4qQkd6G6QQb8S+TxeQS8gDdm47WyT9Sw+60wEL0xN6J0tZyOOcB4LiMVfRtBqDVnaJfHCXyv9Qra2lHRzmd1WD+eUrcxlMwPZLEHdWl8W/8hZHbLwSDYTkGWe2Xgp+V5WnMkO42UappJ14DIpKDt2yJoMCd3JNjw1KEfKlqxd/e6IskvCTaiH5G3JvjNyMpVsFCeLvi8EI1jQsLLQSVLaZTuRbmg7WTMhRwvIhMQ4tN963XNka6DuqGss3kHaYR2uy2KvCaizLACTdTCyA0svvLO6fkamn2XR1Xw6NUVfypYw/eX4LOs/vkVdpO4S8rqa3KsZl2p+JzsoyjF3sqOiZBqsIM97Yakk9Z+EtqvG+y/FXwIPyQKyDWhPQv1HgwdC0A+yEa+6Z7K0zUiULXUNBI/ILjJHzjAfShuHaoRFJz7YpQ+4m/GJq5am6a6fSTzD2MHopPluGGMXYyz+f5KRw5jHeJWRxljJSMD171DPGzVljMR3PzLMjCcYZYxvGHMZKxivMeJ09RnMWIPy/8NYwtjDmMDowNjJ2Mv4CGUtYFzKmIg6/sT4lJGN3wcxXkEdozTPCWR8iHLuZJQyclGWXL+dcZixlPEyYxVjG+MqxutYWyHt8QXe8SlGtO5dQhkzGUfxnDdQxgZGZ9wzHO2UyYjR/PY9RjHq+AOuT/fShx3RFgcYbzFmMw7imYG4Zwaes0DzuxS05XHGO4yfGZsZA3D9CfxG+uoDxnLGx4wLfgU+/K+G3xfor+tvvpBxF6MGP/he13hnEs+hUbTl98V3Ixj9GYWMBzXXLwCjvg0meBn1/AjCQGAGoc9R9hu47qsuNjDyat33wrRdGaPw3BEefvs4OjgR/9/AKGBczRjKSGeM0dx/MZhjMkMmajcxnse1y/HOT2kYLJIxHte+QLvV17Z/ZRxDXdTvOoDR2+J/ecYRDAK/09ynDkaqMEs7HtINZGqbfcXIYFyk+V6Y/GaGFYOQMPZuxnr0KeF+aZeH8X8rxhbGfPz/Itq79a84QBP69Rj4xa7ph5PQ+xtbYa6sxP+ySZgsXx1Mnk9GbQzJOulwqF9ZyHQpzAcxlRwwdUQta1PQRW2/Qu4DJ8UMkH1i36DaAze7Qi3/H9R2CJ7TCvcPguq+iOqeoiumkeRlxcDEUw/fWQ0TqgZQDxkdijpEwgyRbAM1p2sH7pVrshRW9sPSHqdwBcyhr9CmFVR7pNk0ci9Dlnwxdc1KEUy5VSi3M8ygS1Fub6qbvt8Gpp2YeXM13x8k96lQYp72wzvIITofwCRVfYgKqs2ekDpkacxKLV2CesjGDdodJmXZwEcwt8QslW2DpqBd1IOL1L251LMZ8mCKqiZ/IdpmGLlPEh6O9404Q7wnfSMHur6I+hF4Zk59Poi6H9Lfyb0lZRxs4YFgln1oQE+OvA1MKfZwmh+VFJuyIzopA53cFY0j5cs6ccmw1S/H3QOfoBMa8Qc87x4w0Jf4/Q34/wSY+Vl8jsdA8BCYl8Dk8s7Pg7Gy0HmfgMmyYcffD0GLBfPIFp77YYNLmk46OnMh7HBhhLUQiifQdiNgi5egfa2a9mwDP8vbEuRSMFsUfiOd+x3Kzsc97dEXvg4THQkG/hQCPxF/N6GO16B/wiCAz9GpC8naQ5C2+AgwDEcfSrlr0Cch4DHhtakQvM6oz4sawZT+/QvuTUB/PIj2qS+wMQmDQJHGr1CjVdHw5S7TDPriZz3pyb/xFq2R0epWNEwvMJW/G6Dl+CkgkWj0F9GIZgjiGHSMw0t0wYx626EZgjAyPgZnawrqasO9EXBMX0Dn2yCEegddmPYWDAjdUZc38KyfoYnmojFt0Do7wQSq5rkRWnGgZnRcDEa4AHVOhBZU29+liwBZyPtyVxsE7yW8m8psWgfdgWu+IleibWXbwukILvSFM78JdUyAFhqNAe81L9GfAB/RqzhomDI8ZySe2weWgQuD4M3QZn+i2r3IWmPQfBUBFRsGMX92NwmFIPm7R5ns7vI/3px/X+HMpWDgKXjR9ugQp4/Oyyf/j/MKRefO1XRwLkbYSgjZBDCf9sSjwRgltqOT26AT/o1RqAqC48J9EWDwhfWEKF0Q7pma72V0/j1G6AKoYP26kc7QOHdhIBFmuhsajfDsXYgYVUPjfKMxZyo1GiNDY5boo4fqJnvfAd7oELTTMC+MLYzTE+8zCgKVDzPXBOGaC216F4R7nIf2k/doCyFa6+E5Q/Ee6nNU3rkc7ylt8Q7a9BkMap9pBEL+zjoN86kGvJEALejyEIouRh2+hZVQdLrxfrG//4bRoLUmvOlNtVVqwrP+xOZboZHV3T8SEF6Wl3wfHfQMzJ8TMFWmo2Fl8+l7NcL1nKbsGDSyA53SDyHaEozwpbDJ1dzwKDBCKQYGEZRkvOtWCGAcGOUraL8qmJyq/X8EgvAQ7PoKtF0R/LgXUZ8nNCHpeLx/NzDmTAiSnHb1KOrRCSPvAfhJl4BZLRhkChHCVVdKnkDbicnwCMqsggYbjLKOQfBz0AbLMepeg3Ir8D6PoU/eRBnaIyM2oC3uQXh2Cfy6PvD1roEg/wX1dsBEvQZlV+J7qbvsTCl7l72N/i3Ae4+BSR2J98vAb3xRKdruFTr1rErVAlG3Xqr3/Hf6laME9UWx9jG66aIKEjK8Bv8/wKhibGUswudvEV2JRCj0SQ9l/wMhTYmCPIooRS7CxCcQmkzU3B+CSJcLEan5CN1uZCQDh3B9B8rKRAj4HsY6RndNeVInJ6I5apRGpV74zoI2UGkcvp+CiMo+RJQOIlI0CuFpF66lI3z9EcrXvr9ZE76Uui1E5Gw36v2y7v5whLclOviuJoqlRtF+QR/oQ+Px+J3QMoSF96JueYiIau/vh7LeRPj6cc21gWjXlxh/Qpn5jO2ING1DlPWs8um5THdfB0nWSvFhREDUI88WwoyKwsjwNdRwFUarxV401gaMguX4/AXUayVMrl06R7gCZdmgfkthNqxC+fL8j2GalMBccODzVpg/2veYD81QpIlEvQFtk61R9+kYee1Uu1H2Moz6CXCCN0Lb7UF0sQPqp/pXu+nU/b+cMB2ica0YZtQhPFd/aIe00zz8rdGN0kWoTxcP1oOMwm+h7EK0yT6YhxY69RSuI+jfY9CI2sNUd0KD5OJd50Dbl0NTFlDj9ytreHpAU96TyCCDzjUZ2bwGGWQIiEEGGQJikEFnnP5fgAEApOtxCMCalToAAAAASUVORK5CYII=">
        <h3 class="header">COST ESTIMATE  <span>{{ $joborder->joborder_id }}</span></h3>
    </div>
    <div>
        <p>MY CASA HOME SERVICE CAR CARE</p>
        <p>Date: <span>{{ $joborder->created_at !== null ?  date_format($joborder->created_at,'Y-m-d') : "" }}</span></p>
        {{--<p>987-2272 / 0917-854-1759</p>--}}
    </div>
    <br>
    <br>
    <div style="padding: 0;margin: 0">
        <div style="display:inline-block;width:60%">
            {{--<p>Date: <span>{{date_format($joborder->created_at,'Y-m-d') }}</span></p>--}}
            <p>Client: <span>{{  $joborder->user->Information !== null ? ucwords($joborder->user->Information->fullname) : ucwords($joborder->user_id) }}</span></p>
            <p>Contact Number: <span>{{  $joborder->user !== null ? $joborder->user->mobile_number : "" }}</span></p>
            <p>Address: <span>{{ ucwords($joborder->location) }} </span></p>
        </div>
        <div style="display:inline-block;">
            <p>Service Date:<span style="font-weight: bold;"> {{$joborder->schedule !== null ? date_format(date_create($joborder->schedule),'Y-m-d') : "" }} </span></p>
            <p>Service Time: <span style="font-weight: bold;"> {{$joborder->schedule !== null ?  date_format(date_create($joborder->schedule),'h:m a') : ""}} </span></p>
            <p>Contact Person: <span >{{ $joborder->user->Information !== null ? ucwords($joborder->user->Information->fullname) : ucwords($joborder->user_id)  }} </span></p>
        </div>
    </div>
    <p >Vehicle: <span> {{ $joborder->Vehicle !== null ? ucwords($joborder->Vehicle->make) . ' ' . ucwords($joborder->Vehicle->model) . ' ' . $joborder->Vehicle->plate_no . ' ' . $joborder->Vehicle->year  : '' }}  </span></p>
    <p >Concern: <span> {{ $joborder->concern !== null ? ucwords($joborder->concern ) : '' }}  </span></p>
    <p >Assessment: <span> {{ $joborder->assessment !== null ? ucwords($joborder->assessment ) : '' }}  </span></p>
    <table style="width:100%">
        <tr>
            <th style="text-align: left !important;">Item</th>
            <th style=" text-align:center;">Qty</th>
            <th style=" text-align:center;">Cost</th>
        </tr>
        <tr>
            <td style="font-weight: bold;">Services</td>
        </tr>
            @foreach ($joborder->items as $service) {
                {{$service}}
                @if($service->type === 'Services')
                    <tr>
                        <td style="text-align: left !important;width: 80%">{{ $service->name == null ? "" : $service->name }}</td>
                        <td style=" text-align:center;width: 20%;">{{ $service->qty == null ? "" : $service->qty }}  </td>
                        <td style=" text-align:center;width: 20%;">{{ $service->cost == null ? "" : number_format($service->cost) }} </td>
                    </tr>
                @endif
            }
        @endforeach
        }
    </table>
    <table style="width:100%">
        <tr>
            <td style="font-weight: bold">Supplies</td>
        </tr>
            @foreach ($joborder->items as $supply) {
                @if($supply->type === 'Supplies')

                    <tr>
                        <td style="text-align: left !important;width: 80%">{{ $service->name == null ? "" : $service->name }}</td>
                        <td style=" text-align:center;width: 20%;">{{ $service->qty == null ? "" : $service->qty }}  </td>
                        <td style=" text-align:center;width: 20%;">{{ $service->cost == null ? "" : number_format($service->cost) }} </td>
                    </tr>
                @endif
            }
        @endforeach
        }
    </table>
    <table style="width:100%">
        <tr>
            <td style="text-align: left !important; width: 50%"></td>
            <td style="text-align:center;width: 50%;font-size: 16px">Total Cost</td>
            <td style="text-align:center;width: 20%;text-decoration: underline">{{ number_format($joborder->total) }} </td>
        </tr>
    </table>
    {{--<div>--}}
        {{--<p>Issued by:  <span>{{ $joborder->Admin !== null  ? ucwords($joborder->Admin->firstname) : "" }} {{  $joborder->Admin !== null ? ucwords($joborder->Admin->lastname)  : ""}} </span></p>--}}
    {{--</div>--}}
    <div>
        <div style="width: 100%;" class="page-break-avoid">
            <div style="display:inline-block;width:50%;height:148px;border-top:1px solid black;border-right: 0px solid white;border-bottom: 1px solid black; border-left:1px solid black ; float: left;">
                <p style="font-size:13px;line-height: normal; !important;padding: 5px 5px 10px 10px; margin: 0">
                    Price quoated is good for 3 days from date of Issue and is subject
                    to change without prior notice. We urge you to take out valuable
                    items and personal belongings prior to the service schedule.It is
                    understood that MYCASA assumees no responsibility for the loss of
                    damage of personal belongings. placed inside the vehicle. In signing
                    ,I authorize MYCASA to perform the above mentioned work on my vehicle
                    which includes use of parts and materials indicated.
                </p>
            </div>
            <div style="padding-left: -2px;border: 1px solid black;height:148px;width:50%;display:inline-block;float: right;">
                <div style="padding: 0;margin: 5px;position: relative">
                    <h4>CONFORME</h4>
                    @if($joborder->client_signature)
                    <img style="width: 280px; height:140px;margin:-10px 5px 0 5px;padding: 0;" src="https://mycasav2.s3-ap-southeast-1.amazonaws.com/{{ $joborder->client_signature == null ? "" : $joborder->client_signature }}">
                    @endif
                </div>
            </div>
        </div>
        <div style="width: 100%;" class="page-break-avoid">
            <h4 style="margin: 10px 0 10px 0">Job Completion</h4>
            <div style="display:inline-block;height: 130px;width:50%;border-top:1px solid black;border-right: 0px solid white;border-bottom: 1px solid black; border-left:1px solid black ; float: left;">
                <p style="font-size:13px;line-height: normal; !important;padding: 5px 5px 5px 10px; margin: 0">
                    This certifies that job mentioned and described above has
                    been completely and successfullyperformed in the said vehicle.
                </p>
            </div>
            <div style="padding-left: 0px;border: 1px solid black;height:130px;width:50%;display:inline-block;float: right;">
                <div style="padding: 0;height:180px;margin: 0px;">
                    <h4>TECHNICIAN</h4>
                    <img style="width: 280px; height:140px;margin:-5px 5px 0 5px;padding: 0;" src="https://mycasav2.s3-ap-southeast-1.amazonaws.com/{{ $joborder->technician_signature == null ? "" : $joborder->technician_signature }}">
                </div>
            </div>
        </div>
    </div>
    {{--<div class="page-break"></div>--}}
</div>
{{--<div>--}}
    {{--<div>--}}
        {{--<img id="logo" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAABdCAYAAADg8yluAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjkzMDhGRDcwODZDNjExRThBMTk4REYxNzg3Njk0QkIzIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjkzMDhGRDcxODZDNjExRThBMTk4REYxNzg3Njk0QkIzIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6OTMwOEZENkU4NkM2MTFFOEExOThERjE3ODc2OTRCQjMiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6OTMwOEZENkY4NkM2MTFFOEExOThERjE3ODc2OTRCQjMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz48v+OGAAAj0klEQVR42uxd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">--}}
        {{--<h3 class="header">SERVICE REPORT <span>{{ $joborder->joborder_id }}</span></h3>--}}
    {{--</div>--}}
    {{--<div>--}}
        {{--<p>MY CASA HOME SERVICE CAR CARE</p>--}}
        {{--<p>Date: <span>{{  date_format($joborder->created_at,'Y-m-d') }} </span></p>--}}
    {{--</div>--}}
    {{--<br>--}}
    {{--<br>--}}
    {{--<div style="padding: 0;margin: 0">--}}
        {{--<div style="display:inline-block;width:60%">--}}{{--ucwords--}}
            {{--                    <p>Date: <span>{{  date_format($joborder->created_at,'Y-m-d') }} </span></p>--}}
            {{--<p>Client: <span>{{  $joborder->user->Information !== null ? ucwords($joborder->user->Information->fullname) : ucwords($joborder->user_id) }}</span></p>--}}
            {{--<p>Contact Number: <span>{{  $joborder->user !== null ? $joborder->user->mobile_number : "" }}</span></p>--}}
            {{--<p>Address: <span>{{ ucwords($joborder->location) }} </span></p>--}}
        {{--</div>--}}
        {{--<div style="display:inline-block;">--}}
            {{--<p>Service Date:<span style="font-weight: bold;"> {{$joborder->schedule !== null ? date_format(date_create($joborder->schedule),'Y-m-d') : "" }} </span></p>--}}
            {{--<p>Service Time: <span style="font-weight: bold;"> {{$joborder->schedule !== null ?  date_format(date_create($joborder->schedule),'h:m a') : ""}} </span></p>--}}
            {{--<p>Contact Person: <span >{{ $joborder->user->Information !== null ? ucwords($joborder->user->Information->fullname) : ucwords($joborder->user_id)  }} </span></p>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<p >Vehicle: <span> {{ $joborder->Vehicle !== null ? ucwords($joborder->Vehicle->make) . ' ' . ucwords($joborder->Vehicle->model) . ' ' . $joborder->Vehicle->plate_no . ' ' . $joborder->Vehicle->year  : '' }}  </span></p>--}}
    {{--<p>Concern: <span> {{ $joborder->concern !== null ? ucwords($joborder->concern ) : '' }}  </span></p>--}}
    {{--<p>Assessment: <span> {{ $joborder->assessment !== null ? ucwords($joborder->assessment ) : '' }}  </span></p>--}}
    {{--<p>Solution: <span> {{ $joborder->solution !== null ? ucwords($joborder->solution ) : '' }}  </span></p>--}}
    {{--<div>--}}
        {{--<div style="display:inline-block;width:65%">--}}{{----}}{{--ucwords--}}

        {{--</div>--}}
        {{--<div style="display:inline-block;"></div>--}}
    {{--</div>--}}
    {{--<br>--}}
    {{--<p>Technician:--}}
        {{--@foreach($joborder->technicians as $technician)--}}
            {{--<span>--}}
                    {{--{{$technician->Information !== null ? $technician->Information->fullname : "" }}--}}
                {{--</span>--}}
        {{--@endforeach--}}
    {{--</p>--}}
    {{--<h4>RECOMMENDATIONS FOR NEXT SERVICE</h4>--}}
    {{--<p style="margin: 5px 0 5px 0">Next Check-up Schedule : {{ $joborder->check_up !== null ? date_format(date_create($joborder->check_up) ,'Y-m-d') : "" }}</p>--}}
    {{--<div>--}}
        {{--<div style="margin: 10px 50px 10px 100px">--}}
            {{--<table width="100%">--}}
                {{--<tr>--}}
                    {{--<th style="text-align: left">Parts</th>--}}
                    {{--<th style="text-align: left">Status</th>--}}
                {{--</tr>--}}
                {{--@foreach(json_decode($joborder->recommendations,true) as $key => $value)--}}
                    {{--<tr>--}}
                        {{--<td>{{ ucwords(str_replace("_"," ",$key)) }}</td>--}}
                        {{--<td>{{ $value == 1 ? "Replace" : "Good"}}</td>--}}
                    {{--</tr>--}}
                {{--@endforeach--}}
            {{--</table>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<p>Feedback: <span> {{ $joborder->feedback !== null ? ucwords($joborder->feedback ) : '' }}  </span></p>--}}
    {{--<p>Before & After:</p>--}}
    {{--<img style="width:250px; height:100px;margin:15px 5px 0 5px;padding: 0;" src="https://mycasav2.s3-ap-southeast-1.amazonaws.com/{{ $joborder->image == null ? "" : $joborder->image }}">--}}
    {{--<div class="page-break-avoid" style="margin-bottom: 0; padding-bottom: 0">--}}
        {{--<p>Issued by:  <span>{{ $joborder->Admin == null ? "" : ucwords($joborder->Admin->firstname) }} {{ $joborder->Admin == null ? "" : ucwords($joborder->Admin->lastname) }}</span></p>--}}
        {{--<div style="width: 100%;">--}}
            {{--<div style="display:inline-block;height: 80px;width:50%;border-top:1px solid black;border-right: 0px solid white;border-bottom: 1px solid black; border-left:1px solid black ; float: left;">--}}
                {{--<div style="padding: 0;height:80px;margin: 0px;">--}}
                    {{--@foreach($joborder->technicians as $technician)--}}
                        {{--<h4>TECHNICIAN 1--}}
                            {{--{{ $technician->Information !== null ? $technician->Information->fullname : "" }}--}}
                        {{--</h4>--}}
                    {{--@endforeach--}}
                    {{--<img style="width: 280px; height:140px;margin:-5px 5px 0 5px;padding: 0;" src="https://mycasav2.s3-ap-southeast-1.amazonaws.com/{{ $joborder->technician_signature == null ? "" : $joborder->technician_signature }}">--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div style="padding-left: 0px;border: 1px solid black;height:80px;width:50%;display:inline-block;float: right;">--}}
                {{--<div style="padding: 0;height:80px;margin: 0px;">--}}
                    {{--<h4>TECHNICIAN 2--}}
                        {{--{{ $joborder->Assistant !== null ? $joborder->Technician->lastname : "" }}--}}
                        {{--{{ $joborder->Assistant !== null ? $joborder->Technician->lastname : "" }}--}}
                    {{--</h4>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="page-break"></div>--}}
    {{--<div>--}}
        {{--<h3 style="margin-top: -10px">VEHICLE IMAGES</h3>--}}
        {{--<br>--}}
        {{--<div class="picture">--}}
            {{--<div style="display:inline-block;width:50%">--}}
                {{--<p>Panel Before</p>--}}
                {{--<img style="width: 280px; height:150px;margin:5px 5px 5px 5px;padding: 0;" src="https://s3-ap-southeast-1.amazonaws.com/mycasafile/images/Image/{{ $joborder->setup == null ? "" : $joborder->setup }}">   --}}{{----}}{{--panel before--}}
            {{--</div>--}}
            {{--<div style="display:inline-block;">--}}
                {{--<p>Setup</p>--}}
                {{--<img style="width: 280px; height:150px;margin:5px 5px 5px 5px;padding: 0;" src="https://s3-ap-southeast-1.amazonaws.com/mycasafile/images/Image/{{ $joborder->instrument_panel_before == null ? "" : $joborder->instrument_panel_before }}">--}}{{----}}{{--set-up--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="picture">--}}
            {{--<div style="display:inline-block;width:50%">--}}
                {{--<p>WIP</p>--}}
                {{--<img style="width: 280px; height:150px;margin:5px 5px 5px 5px;padding: 0;" src="https://s3-ap-southeast-1.amazonaws.com/mycasafile/images/Image/{{ $joborder->front == null ? "" : $joborder->front  }}">  --}}{{----}}{{--WIP--}}
            {{--</div>--}}
            {{--<div style="display:inline-block;">--}}
                {{--<p>Panel After</p>--}}
                {{--<img style="width: 280px; height:150px;margin:5px 5px 5px  5px;padding: 0;" src="https://s3-ap-southeast-1.amazonaws.com/mycasafile/images/Image/{{ $joborder->driver == null ? "" : $joborder->driver }}">--}}

            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="picture">--}}
            {{--<div style="display:inline-block;width:50%">--}}
                {{--<p>Reco1</p>--}}
                {{--<img style="width: 280px; height:150px;margin:5px 5px 5px 5px;padding: 0;" src="https://s3-ap-southeast-1.amazonaws.com/mycasafile/images/Image/{{ $joborder->passenger == null ? "" : $joborder->passenger }}">--}}
            {{--</div>--}}
            {{--<div style="display:inline-block;">--}}
                {{--<p>Reco2</p>--}}
                {{--<img style="width: 280px; height:150px;margin:5px 5px 5px 5px;padding: 0;" src="https://s3-ap-southeast-1.amazonaws.com/mycasafile/images/Image/{{ $joborder->rear == null ? "" : $joborder->rear }}">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="picture">--}}
            {{--<div style="display:inline-block;width:50%">--}}
                {{--<p>Reco3</p>--}}
                {{--<img style="width: 280px; height:150px;margin:5px 5px 5px 5px;padding: 0;" src="https://s3-ap-southeast-1.amazonaws.com/mycasafile/images/Image/{{ $joborder->instrument_panel_after == null ? "" : $joborder->instrument_panel_after }}">--}}
            {{--</div>--}}
            {{--<div style="display:inline-block;">--}}
                {{--<p>Reco4</p>--}}
                {{--<img style="width: 280px; height:150px;margin:5px 5px 5px 5px;padding: 0;" src="https://s3-ap-southeast-1.amazonaws.com/mycasafile/images/Image/{{ $joborder->consumed_material == null ? "" : $joborder->consumed_material }}">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="picture">--}}
            {{--<div style="display:inline-block;width:50%">--}}
                {{--<p>Client</p>--}}
                {{--<img style="width: 280px; height:140px;" src="https://s3-ap-southeast-1.amazonaws.com/mycasafile/images/Image/{{ $joborder->client == null ? "" : $joborder->client }}">--}}
            {{--</div>--}}
            {{--<div style="display:inline-block;"></div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--</div>--}}
</body>
</html>

