import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

async function main() {
  const products = [
    {
      name: "Saira's Salted Machiatta",
      slug: "sairas-salted-machiatta",
      description: "A signature blend with a touch of sweetness and saltiness, crafted for Saira.",
      price: 165.00,
      category: "Specialty",
      image: "/images/Saira's Salted Machiatta.png",
      status: "available"
    },
    {
      name: "Nell's Caramel Hell",
      slug: "nells-caramel-hell",
      description: "A fiery and sweet caramel delight that lives up to its name. Nell's favorite.",
      price: 160.00,
      category: "Specialty",
      image: "/images/Nell's Caramel Hell.png",
      status: "available"
    },
    {
      name: "Van's Flat Leche Flan",
      slug: "vans-flat-leche-flan",
      description: "Creamy, smooth, and inspired by the classic Filipino dessert. Van's special.",
      price: 170.00,
      category: "Specialty",
      image: "/images/van's flat leche flan.png",
      status: "available"
    },
    {
      name: "Martin's Black Choco Macho",
      slug: "martins-black-choco-macho",
      description: "Bold dark chocolate with a masculine punch. Martin's signature brew.",
      price: 160.00,
      category: "Specialty",
      image: "/images/Martin's black choco.png",
      status: "available"
    }
  ];

  for (const product of products) {
    const existing = await prisma.product.findUnique({
      where: { slug: product.slug }
    });

    if (!existing) {
      await prisma.product.create({
        data: product
      });
      console.log(`Created product: ${product.name}`);
    } else {
      await prisma.product.update({
        where: { slug: product.slug },
        data: product
      });
      console.log(`Updated product: ${product.name}`);
    }
  }
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
